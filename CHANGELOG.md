# Cortex Tenants Change Log

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](CONTRIBUTING.md).


## [v2.1.0] - 2019-06-02
- Update composer deps
- Drop PHP 7.1 travis test
- Refactor migrations and artisan commands, and tweak service provider publishes functionality

## [v2.0.0] - 2019-03-03
- Require PHP 7.2 & Laravel 5.8
- Utilize includeWhen blade directive
- Refactor abilities seeding
- Add files option to the form to allow file upload
- Drop ownership feature of tenants

## [v1.0.2] - 2019-01-03
- Rename environment variable QUEUE_DRIVER to QUEUE_CONNECTION
- Fix wrong media destroy route
- Add missing language phrase
- Simplify and flatten create & edit form controller actions
- Tweak and simplify FormRequest validations
- Enable tinymce on all description and text area fields

## [v1.0.1] - 2018-12-22
- Update composer dependencies
- Add PHP 7.3 support to travis
- Utilize @json() blade directive

## [v1.0.0] - 2018-10-01
- Support Laravel v5.7, bump versions and enforce consistency

## [v0.0.2] - 2018-09-22
- Too much changes to list here!!

## v0.0.1 - 2017-09-09
- Tag first release

[v2.0.0]: https://github.com/rinvex/cortex-tenants/compare/v1.0.2...v2.0.0
[v1.0.2]: https://github.com/rinvex/cortex-tenants/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/rinvex/cortex-tenants/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/rinvex/cortex-tenants/compare/v0.0.2...v1.0.0
[v0.0.2]: https://github.com/rinvex/cortex-tenants/compare/v0.0.1...v0.0.2
