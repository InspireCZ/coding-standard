# Changelog: inspirecz/coding-standard
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [4.1.4] - 2024-11-19
### Added
- Inspire.ControlStructures.DisallowHashComments added to basic ruleset

## [4.1.0] - 2024-11-06
### Added
- Inspire.ControlStructures.ControlStructureSpacing to basic ruleset

## [4.0.2] - 2023-08-16
### Changed
- fix sniff path in `ruleset.nw6.xml`

## [4.0.1] - 2023-08-16
### Changed
- sniffs removed, they need to be loaded from separate package for PHPCS's plugin detecting `installed_paths` to work

## [4.0.0] - 2023-08-16
### Added
- sniffs from `inspirecz/coding-standard-sniffs`

Rereleased v2.5.4 as new major version - for use with Webspire 7 PHP 8.0.


## [3.1.1] - 2023-08-16
### Discontinued
Major version v3 was intended for Webspire 8. However as we need to develop Webspire 7 packages for PHP 8.2, CS for WSP8 was moved to separate package `webspire8/coding-standard`.
All tags of v3 will be removed and former v2.5 will be retagged as v4 (so as to avoid conflict if v3 would be reused).
If coding standard would need to change for PHP 8.2, new version will be released as v5.

## [2.5.4] - 2022-05-27
### Changed
- updated stylelint configuration to include more rules

## [2.5.0] - 2021-02-10
### Added
- first release for PHP 8.0
- added `public/protected static abstract method` order setting

## [2.0.2] - 2020-10-07
### Changed
- fixed empty catch statement rule name

## [2.0.0] - 2020-01-30
### Changed
- updated dependencies (slevovomat/coding-standard)
- basic ruleset checks more rules (i.e. constant/properties/methods order)

## [1.0.3] - 2020-01-29
### Added
- Add Inspire.Sniffs.Classes.EmptyInterfaceSniff to ruleset.xml

## [1.0.2] - 2018-09-20
### Changed
- replaced `Inspire.ControlStructures.YodaConditions` with `SlevomatCodingStandard.ControlStructures.RequireYodaComparison` in `ruleset.nw6.xml`
- fixed path to Inspire sniffs in `ruleset.nw6.xml`

## [1.0.1] - 2018-09-20
### Added
- license info to composer.json

## 1.0.0 - 2018-09-20
Initial release

[2.0.0]: https://github.com/InspireCZ/coding-standard/compare/2.0.0..1.0.3
[1.0.3]: https://github.com/InspireCZ/coding-standard/compare/1.0.3..1.0.2
[1.0.2]: https://github.com/InspireCZ/coding-standard/compare/1.0.2..1.0.1
[1.0.1]: https://github.com/InspireCZ/coding-standard/compare/1.0.1..1.0.0
