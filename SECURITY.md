# Security Policy

## Supported Versions

Security reports are accepted for the currently maintained version of Kumar Commerce Intelligence.

| Version | Security Support |
| ------- | ---------------- |
| 1.0.x   | Current release  |

## Reporting a Vulnerability

If you discover a potential security vulnerability, please do not disclose sensitive exploit details in a public GitHub issue.

Instead, use GitHub's private vulnerability reporting feature if enabled for this repository.

If private reporting is unavailable, contact the repository maintainer through the contact information available on the GitHub profile.

## Security Considerations

When using or extending this module:

* Restrict dashboard access through appropriate Magento ACL permissions.
* Never expose sensitive customer information unnecessarily.
* Validate and sanitize user inputs.
* Protect admin controllers and endpoints.
* Avoid committing API keys, passwords or access tokens.
* Do not publish production database exports or customer information.
* Review third-party dependencies and their security advisories.

## Responsible Disclosure

Please allow the maintainer reasonable time to investigate and address reported vulnerabilities before publicly disclosing technical details.
