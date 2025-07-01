# Moment.php Improvement TODO List

## 🚨 High Priority

### 1. Refactor Complex Methods
- [ ] Break down `isValidDate()` method (src/Moment.php:1311-1411) into smaller validation methods
  - Extract regex patterns as constants
  - Create separate validators for each date format type
  - Implement a chain of responsibility pattern for format detection
- [ ] Refactor `format()` method (src/Moment.php:244-302) to separate concerns
  - Extract ordinal handling logic
  - Separate text escaping functionality
  - Create dedicated formatter classes
- [ ] Simplify period calculation methods using strategy pattern instead of large switch statements

### 2. Add Comprehensive Test Coverage
- [ ] Achieve minimum 80% code coverage
- [ ] Add tests for all exception scenarios
- [ ] Create timezone edge case tests (DST transitions, UTC boundaries)
- [ ] Add locale switching tests
- [ ] Implement integration tests for common workflows
- [ ] Add performance benchmarks

### 3. Fix Security Concerns
- [ ] Validate and sanitize locale file paths in `MomentLocale::loadLocaleContent()`
- [ ] Add input validation for `resetDateTime()` method
- [ ] Implement safe file loading mechanism for locale files
- [ ] Add security policy documentation

## 📦 Medium Priority

### 4. Modernize Codebase (While Maintaining BC)
- [ ] Create a roadmap for dropping PHP 5.3 support
- [ ] Add type declarations progressively:
  - [ ] Start with internal/private methods
  - [ ] Add parameter types where BC allows
  - [ ] Use PHPDoc for return types initially
- [ ] Implement strict types in new code
- [ ] Consider creating a v3.0 branch for breaking changes

### 5. Reduce Code Duplication
- [ ] Consolidate add/subtract methods (addSeconds, addMinutes, etc.)
  - Consider using `__call()` magic method
  - Or create a single `modify()` method with parameters
- [ ] Extract common getter logic into a base method
- [ ] Create shared validation functions
- [ ] Implement DRY principle in setter methods

### 6. Improve Architecture
- [ ] Extract parsing logic into a dedicated `MomentParser` class
- [ ] Create `MomentFormatter` for all formatting operations
- [ ] Implement `MomentValidator` for date validation
- [ ] Consider composition over inheritance from `\DateTime`
- [ ] Define interfaces for better abstraction
- [ ] Implement value objects for complex data

### 7. Standardize Locale Files
- [ ] Create a base locale class/template
- [ ] Fix typo in en_GB.php (duplicate 'F' in LLLL format)
- [ ] Ensure all locales have consistent structure
- [ ] Add missing `monthsNominative` where applicable
- [ ] Create locale inheritance system to reduce duplication
- [ ] Add locale validation tests

## 🔧 Low Priority / Nice to Have

### 8. Development Experience Improvements
- [ ] Add static analysis tools:
  - [ ] PHPStan (level 6+)
  - [ ] Psalm
  - [ ] PHP CS Fixer with custom ruleset
- [ ] Create development container configuration
- [ ] Add pre-commit hooks for code quality
- [ ] Implement automated changelog generation

### 9. Documentation Enhancements
- [ ] Add comprehensive PHPDoc for all public methods
- [ ] Include code examples in documentation
- [ ] Document all thrown exceptions
- [ ] Create architecture decision records (ADRs)
- [ ] Add inline comments for complex logic
- [ ] Create developer guide for contributors
- [ ] Add migration guide for major versions

### 10. Performance Optimizations
- [ ] Cache parsed formats
- [ ] Optimize regex operations
- [ ] Lazy-load locale files
- [ ] Benchmark common operations
- [ ] Consider using DateTimeImmutable internally

### 11. Additional Features
- [ ] Add fluent interface for all operations
- [ ] Implement period/duration classes
- [ ] Add business day calculations
- [ ] Support for fiscal calendars
- [ ] Add more custom format options
- [ ] Implement plugin system for extensions

## 📊 Quality Metrics Goals

- **Code Coverage**: Increase from current to 80%+
- **Cyclomatic Complexity**: Reduce methods with complexity > 10
- **Code Duplication**: Reduce to < 5%
- **PHPStan Level**: Achieve level 6 compliance
- **Documentation**: 100% public API documentation

## 🚀 Suggested Release Plan

### Version 2.x (Backward Compatible)
- Refactoring and code quality improvements
- Enhanced test coverage
- Security fixes
- Documentation improvements

### Version 3.0 (Breaking Changes)
- Require PHP 7.4+
- Full type declarations
- New architecture with separate components
- Modern PHP features adoption
- Improved performance

## 📝 Notes

- Maintain backward compatibility in 2.x releases
- Consider creating a `develop` branch for v3.0 work
- Engage community for feedback on breaking changes
- Update CI/CD to test against all supported PHP versions
- Consider adopting Semantic Versioning strictly