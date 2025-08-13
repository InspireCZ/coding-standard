const stylelint = require("stylelint");

const ruleName = "custom/no-class-prefix";
const messages = stylelint.utils.ruleMessages(ruleName, {
    rejected: (prefix, token) =>
        `Disallowed use of class prefix '${prefix}' in selector: "${token}"`
});

// ----- helpers -----
const isNonEmptyString = v => typeof v === "string" && v.trim().length > 0;
const normalizePrefixes = (opt) =>
    Array.isArray(opt) ? opt.filter(isNonEmptyString) : (isNonEmptyString(opt) ? [opt] : []);

const whichPrefixIn = (str, prefixes, {startsWithOnly = false} = {}) => {
    if (typeof str !== "string") return null;
    for (const p of prefixes) {
        if (startsWithOnly ? str.startsWith(p) : str.includes(p)) return p;
    }
    return null;
};

const escapeForRegex = (s) => s.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");

module.exports = stylelint.createPlugin(ruleName, (primaryOption) => {
    return (root, result) => {
        const prefixes = normalizePrefixes(primaryOption);

        const validOptions = stylelint.utils.validateOptions(result, ruleName, {
            actual: prefixes,
            possible: (value) =>
                Array.isArray(value) &&
                value.length > 0 &&
                value.every(isNonEmptyString)
        });

        if (!validOptions) return;

        // Prebuild alternation for regex fallbacks
        const alts = prefixes.map(escapeForRegex).join("|");
        if (!alts) return;

        const rePlainClass = new RegExp(`\\.(?:${alts})[A-Za-z0-9_-]*`, "g"); // .prefixSomething
        const reInterpolatedClass = new RegExp(`\\.#{[^}]*?(?:${alts})[^}]*}`, "g"); // .#{ ... prefix ... }
        const reAttrContains = new RegExp( // [class*= "prefix" ] (with/without interpolation)
            `\\[class(?:\\^=|\\$=|\\*=|~=|=)\\s*(?:["'][^"']*(?:${alts})[^"']*["']|#\\{[^}]*?(?:${alts})[^}]*\\})\\s*\\]`,
            "g"
        );

        root.walkRules((rule) => {
            if (!rule.selector) return;

            const sel = rule.selector;

            [rePlainClass, reInterpolatedClass, reAttrContains].forEach((re) => {
                let m;
                while ((m = re.exec(sel)) !== null) {
                    const start = m.index;
                    const end = start + m[0].length; // <-- required by Stylelint now
                    const matchedPrefix = whichPrefixIn(m[0], prefixes) || "(unknown)";

                    stylelint.utils.report({
                        message: messages.rejected(matchedPrefix, m[0]),
                        node: rule,
                        index: start,
                        endIndex: end, // <-- add this
                        result,
                        ruleName
                    });
                }
            });
        });
    };
});

module.exports.ruleName = ruleName;
module.exports.messages = messages;
