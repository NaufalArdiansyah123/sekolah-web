# Qodo Configuration for sekolah-web

This directory contains Qodo configuration files for the sekolah-web Laravel project.

## Files

- `workflows.yml` - Defines automated workflows for code analysis and review
- `../qodo.json` - Main Qodo configuration file
- `../.qodoignore` - Files and directories to ignore during analysis

## Usage

### Basic Commands

```bash
# Analyze the entire codebase
npm run qodo:analyze

# Review recent changes
npm run qodo:review

# Run tests with Qodo integration
npm run qodo:test
```

### Manual Commands

```bash
# Initialize Qodo (already done)
qodo init

# Analyze specific files
qodo analyze app/Models/User.php

# Review a specific commit
qodo review --commit <commit-hash>

# Generate a comprehensive report
qodo report --format html --output reports/
```

## Workflows

### Code Analysis
- Runs security, performance, and quality analysis
- Triggered on commits or manually
- Configurable severity levels

### Pre-commit Review
- Quick security and lint checks
- Runs automatically before commits (if enabled)
- Focuses on high-severity issues

### Pull Request Review
- Comprehensive analysis for PRs
- Includes test coverage checks
- Generates detailed markdown reports

## Configuration

The main configuration is in `.qodo.json` and includes:

- **Project Settings**: Laravel-specific configurations
- **Analysis Rules**: Security, performance, maintainability checks
- **Testing Integration**: PHPUnit integration
- **Git Hooks**: Optional pre-commit and pre-push hooks
- **Framework Integration**: Laravel, Vite, Tailwind, Alpine.js

## Customization

You can customize the analysis by modifying:

1. `.qodo.json` - Main configuration
2. `.qodoignore` - Files to exclude
3. `workflows.yml` - Automated workflows
4. Individual workflow steps and triggers

## Getting Started

1. Ensure Qodo CLI is installed
2. Run `qodo analyze` to perform initial analysis
3. Review the generated reports
4. Configure git hooks if desired: `qodo hooks install`
5. Customize workflows based on your team's needs