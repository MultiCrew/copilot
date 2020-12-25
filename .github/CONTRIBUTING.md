# Contributing to MultiCrew

:+1::tada: Welcome to the official Copilot repository, MultiCrew's primary project :tada::+1:

The following is a set of guidelines for contributing to MultiCrew and its software, which are hosted in the [MultiCrew Organization](https://github.com/MultiCrew) on GitHub. These are mostly guidelines, not rules. Use your best judgment, and feel free to propose changes to this document in a pull request.

#### Table Of Contents

[Code of Conduct](#code-of-conduct)

[What should I know before I get started?](#what-should-i-know-before-i-get-started)
  * [MultiCrew and Packages](#atom-and-packages)

[How Can I Contribute?](#how-can-i-contribute)
  * [Reporting Bugs](#reporting-bugs)
  * [Suggesting Enhancements](#suggesting-enhancements)
  * [Your First Code Contribution](#your-first-code-contribution)
  * [Pull Requests](#pull-requests)

[Styleguides](#styleguides)
  * [Git Commit Messages](#git-commit-messages)
  * [PHP Styleguide](#php-styleguide)
  * [Documentation Styleguide](#documentation-styleguide)

[Additional Notes](#additional-notes)
  * [Issue and Pull Request Labels](#issue-and-pull-request-labels)

## Code of Conduct

This project and everyone participating in it is governed by the [MultiCrew Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code. Please report unacceptable behavior to [calum.shep@icloud.com](mailto:calum.shep@icloud.com).

## What should I know before I get started?

### MultiCrew and its Software

MultiCrew's software is all open source projects.

#### Copilot

MultiCrew Copilot is primarily a tool for organising shared cockpit flights, creating, reviewing and distributing flight plans and logging flights. Users can create public 'flight requests' for other users to join, or private ones to share with friends. When connected together, users can then make use of the dispatch options available to create a SimBrief flight plan, through the SimBrief API. They must then review and accept this plan, or reject and re-plan, before flying. The flight should be marked as complete when the flight plan is no longer in use (the flight has arrived).

#### Discord Bot

We also host a [Discord Bot](https://github.com/MultiCrew/bot) for the purposes of integrating our services and providing mobile push notifications.

## How Can I Contribute?

### Reporting Bugs

This section guides you through submitting a bug report for Copilot. Following these guidelines helps maintainers and the community understand your report :pencil:, reproduce the behavior :computer: :computer:, and find related reports :mag_right:.

Before creating bug reports, please check [this list](#before-submitting-a-bug-report) as you might find out that you don't need to create one. When you are creating a bug report, please [include as many details as possible](#how-do-i-submit-a-good-bug-report). Fill out [the required template](https://github.com/MultiCrew/copilot/blob/master/.github/ISSUE_TEMPLATE/bug_report.md), the information it asks for helps us resolve issues faster.

> **Note:** If you find a **Closed** issue that seems like it is the same thing that you're experiencing, open a new issue and include a link to the original issue in the body of your new one.

#### Before Submitting A Bug Report

* **Perform a [cursory search](https://github.com/search?q=+is%3Aissue+user%3AMultiCrew)** to see if the problem has already been reported. If it has **and the issue is still open**, feel free to add a comment to the existing issue instead of opening a new one.

#### How Do I Submit A (Good) Bug Report?

Bugs are tracked as [GitHub issues](https://guides.github.com/features/issues/). Create an issue in the repository and provide the following information by filling in [the template](https://github.com/MultiCrew/copilot/blob/master/.github/ISSUE_TEMPLATE/bug_report.md).

Explain the problem and include additional details to help maintainers reproduce the problem:

* **Use a clear and descriptive title** for the issue to identify the problem.
* **Describe the exact steps which reproduce the problem** in as many details as possible. For example, start by explaining what action you were performing and what you did leading up to that. When listing steps, **don't just say what you did, but explain how you did it**. For example, if you used a button, explain if you used the mouse or a keyboard shortcut, and if so which one?
* **Provide specific examples to demonstrate the steps**. Include links to files or GitHub projects, or copy/pasteable snippets, which you use in those examples. If you're providing snippets in the issue, use [Markdown code blocks](https://help.github.com/articles/markdown-basics/#multiple-lines).
* **Describe the behavior you observed after following the steps** and point out what exactly is the problem with that behavior.
* **Explain which behavior you expected to see instead and why.**
* **Include screenshots and animated GIFs** which show you following the described steps and clearly demonstrate the problem. If you use the keyboard while following the steps, **annotate or otherwise communicate what keys were pressed and when**. You can use [this tool](https://www.cockos.com/licecap/) to record GIFs on macOS and Windows, and [this tool](https://github.com/colinkeenan/silentcast) or [this tool](https://github.com/GNOME/byzanz) on Linux.
* **If you're reporting that Copilot crashed, hung, threw an exception, etc.**, include a stack trace from the web browser. MultiCrew uses . Include the trace in the issue in a [code block](https://help.github.com/articles/markdown-basics/#multiple-lines), a [file attachment](https://help.github.com/articles/file-attachments-on-issues-and-pull-requests/), or put it in a [gist](https://gist.github.com/) and provide link to that gist.
* **If the problem wasn't triggered by a specific action**, describe what you were doing before the problem happened and share more information using the guidelines below.

Provide more context by answering these questions:

* **Did the problem start happening recently** (e.g. after pulling the repository) or was this always a problem?
* If the problem started happening recently, **can you reproduce the problem in an older version of Copilot?** What's the most recent version in which the problem doesn't happen?
* **Can you reliably reproduce the issue?** If not, provide details about how often the problem happens and under which conditions it normally happens.

Include details about your configuration and environment:

* **Which version of Copilot are you using?** Inlcude the branch of the repository which you are working with, as well as the last commit .
* **What's the name and version of the OS you're using**?
* **Are you running Copilot in a virtual machine?** If so, which VM software are you using and which operating systems and versions are used for the host and the guest?

### Suggesting Enhancements

This section guides you through submitting an enhancement suggestion for Copilot, including completely new features and minor improvements to existing functionality. Following these guidelines helps maintainers and the community understand your suggestion :pencil: and find related suggestions :mag_right:.

Before creating enhancement suggestions, please check [this list](#before-submitting-an-enhancement-suggestion) as you might find out that you don't need to create one. When you are creating an enhancement suggestion, please [include as many details as possible](#how-do-i-submit-a-good-enhancement-suggestion). Fill in [the template](https://github.com/MultiCrew/copilot/blob/master/.github/ISSUE_TEMPLATE/feature_request.md), including the steps that you imagine you would take if the feature you're requesting existed.

#### Before Submitting An Enhancement Suggestion

* **Perform a [cursory search](https://github.com/search?q=+is%3Aissue+user%3AMultiCrew)** to see if the enhancement has already been suggested. If it has, feel free to add a comment to the existing issue instead of opening a new one.

#### How Do I Submit A (Good) Enhancement Suggestion?

Enhancement suggestions are tracked as [GitHub issues](https://guides.github.com/features/issues/). Create an issue in the repository and provide the following information:

* **Use a clear and descriptive title** for the issue to identify the suggestion.
* **Provide a step-by-step description of the suggested enhancement** in as many details as possible.
* **Provide specific examples to demonstrate the steps**. Include copy/pasteable snippets which you use in those examples, as [Markdown code blocks](https://help.github.com/articles/markdown-basics/#multiple-lines).
* **Describe the current behavior** and **explain which behavior you expected to see instead** and why.
* **Include screenshots and animated GIFs** which help you demonstrate the steps or point out the part of Copilot which the suggestion is related to. You can use [this tool](https://www.cockos.com/licecap/) to record GIFs on macOS and Windows, and [this tool](https://github.com/colinkeenan/silentcast) or [this tool](https://github.com/GNOME/byzanz) on Linux.
* **Explain why this enhancement would be useful** to most Copilot users.
* **List some other software or applications where this enhancement exists.**

### Your First Code Contribution

Unsure where to begin contributing to MultiCrew? You can start by looking through these `beginner` and `help-wanted` issues:

* [Beginner issues][beginner] - issues which should only require a few lines of code, and a test or two.
* [Help wanted issues][help-wanted] - issues which should be a bit more involved than `beginner` issues.

Both issue lists are sorted by total number of comments. While not perfect, number of comments is a reasonable proxy for impact a given change will have.

#### Local development

MultiCrew uses Homestead, the Laravel development environment shipped as a vagrant box, to develop locally. For instructions on how to do this, read up on the [Laravel docs](https://laravel.com/docs/7.x/homestead). MutliCrew also ships a `Vagrantfile` with each of its repositories so you can simply `vagrant up` in the repository once you've cloned it.

### Pull Requests

The process described here has several goals:

- Maintain MultiCrew's quality
- Fix problems that are important to users
- Engage the community in working toward the best possible Copilot
- Enable a sustainable system for MultiCrew's maintainers to review contributions

Please follow these steps to have your contribution considered by the maintainers:

1. Follow all instructions in [the template](PULL_REQUEST_TEMPLATE.md)
2. Follow the [styleguides](#styleguides)
3. After you submit your pull request, verify that all [status checks](https://help.github.com/articles/about-status-checks/) are passing <details><summary>What if the status checks are failing?</summary>If a status check is failing, and you believe that the failure is unrelated to your change, please leave a comment on the pull request explaining why you believe the failure is unrelated. A maintainer will re-run the status check for you. If we conclude that the failure was a false positive, then we will open an issue to track that problem with our status check suite.</details>

While the prerequisites above must be satisfied prior to having your pull request reviewed, the reviewer(s) may ask you to complete additional design work, tests, or other changes before your pull request can be ultimately accepted.

## Styleguides

### Git Commit Messages

* Please follow [this guide](https://chris.beams.io/posts/git-commit/) when writing commit messages.

### PHP Styleguide

* All PHP must conform to [PSR-12](https://www.php-fig.org/psr/psr-12/) standards.

## Additional Notes

### Issue and Pull Request Labels

This section lists the labels we use to help us track and manage issues and pull requests. Most labels are used across all MultiCrew repositories, but some are specific to `MultiCrew/copilot`.

[GitHub search](https://help.github.com/articles/searching-issues/) makes it easy to use labels for finding groups of issues or pull requests you're interested in. For example, you might be interested in [open issues across `MultiCrew/copilot` and all MultiCrew-owned packages which are labeled as bugs, but still need to be reliably reproduced](https://github.com/search?utf8=%E2%9C%93&q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Abug+label%3Aneeds-reproduction) or perhaps [open pull requests in `MultiCrew/copilot` which haven't been reviewed yet](https://github.com/search?utf8=%E2%9C%93&q=is%3Aopen+is%3Apr+repo%3AMultiCrew%2Fcopilot+comments%3A0). To help you find issues and pull requests, each label is listed with search links for finding open items with that label in `MultiCrew/copilot` only and also across all MultiCrew repositories. We  encourage you to read about [other search filters](https://help.github.com/articles/searching-issues/) which will help you write more focused queries.

The labels are loosely grouped by their purpose, but it's not required that every issue has a label from every group or that an issue can't have more than one label from the same group.

Please open an issue on `MultiCrew/copilot` if you have suggestions for new labels, and if you notice some labels are missing on some repositories, then please open an issue on that repository.

#### Type of Issue and Issue State

| Label name | `MultiCrew/copilot` :mag_right: | `MultiCrew` :mag_right: | Description |
| --- | --- | --- | --- |
| `enhancement` | [search][search-copilot-label-enhancement] | [search][search-multicrew-label-enhancement] | Feature requests. |
| `bug` | [search][search-copilot-label-bug] | [search][search-multicrew-label-bug] | Confirmed bugs or reports that are very likely to be bugs. |
| `question` | [search][search-copilot-label-question] | [search][search-multicrew-label-question] | Questions more than bug reports or feature requests (e.g. how do I do X). |
| `feedback` | [search][search-copilot-label-feedback] | [search][search-multicrew-label-feedback] | General feedback more than bug reports or feature requests. |
| `help-wanted` | [search][search-copilot-label-help-wanted] | [search][search-multicrew-label-help-wanted] | The MultiCrew team would appreciate help from the community in resolving these issues. |
| `beginner` | [search][search-copilot-label-beginner] | [search][search-multicrew-label-beginner] | Less complex issues which would be good first issues to work on for users who want to contribute to MultiCrew. |
| `more-information-needed` | [search][search-copilot-label-more-information-needed] | [search][search-multicrew-label-more-information-needed] | More information needs to be collected about these problems or feature requests (e.g. steps to reproduce). |
| `needs-reproduction` | [search][search-copilot-label-needs-reproduction] | [search][search-multicrew-label-needs-reproduction] | Likely bugs, but haven't been reliably reproduced. |
| `blocked` | [search][search-copilot-label-blocked] | [search][search-multicrew-label-blocked] | Issues blocked on other issues. |
| `duplicate` | [search][search-copilot-label-duplicate] | [search][search-multicrew-label-duplicate] | Issues which are duplicates of other issues, i.e. they have been reported before. |
| `wontfix` | [search][search-copilot-label-wontfix] | [search][search-multicrew-label-wontfix] | The MultiCrew team has decided not to fix these issues for now, either because they're working as intended or for some other reason. |
| `invalid` | [search][search-copilot-label-invalid] | [search][search-multicrew-label-invalid] | Issues which aren't valid (e.g. user errors). |

#### Topic Categories

| Label name | `MultiCrew/copilot` :mag_right: | `MultiCrew` :mag_right: | Description |
| --- | --- | --- | --- |
| `documentation` | [search][search-copilot-label-documentation] | [search][search-multicrew-label-documentation] | Related to any type of documentation (e.g. PHPDoc comments or the help pages). |
| `performance` | [search][search-copilot-label-performance] | [search][search-multicrew-label-performance] | Related to performance. |
| `security` | [search][search-copilot-label-security] | [search][search-multicrew-label-security] | Related to security. |
| `ui` | [search][search-copilot-label-ui] | [search][search-multicrew-label-ui] | Related to visual design. |
| `api` | [search][search-copilot-label-api] | [search][search-multicrew-label-api] | Related to MultiCrew's public APIs. |
| `uncaught-exception` | [search][search-copilot-label-uncaught-exception] | [search][search-multicrew-label-uncaught-exception] | Issues about uncaught exceptions. |
| `crash` | [search][search-copilot-label-crash] | [search][search-multicrew-label-crash] | Reports of MultiCrew completely crashing. |
| `laravel` | [search][search-copilot-label-laravel] | [search][search-multicrew-label-laravel] | Issues that require changes to [Laravel](https://laravel.com/) to fix or implement. |

#### Pull Request Labels

| Label name | `MultiCrew/copilot` :mag_right: | `MultiCrew` :mag_right: | Description
| --- | --- | --- | --- |
| `work-in-progress` | [search][search-copilot-label-work-in-progress] | [search][search-multicrew-label-work-in-progress] | Pull requests which are still being worked on, more changes will follow. |
| `needs-review` | [search][search-copilot-label-needs-review] | [search][search-multicrew-label-needs-review] | Pull requests which need code review, and approval from maintainers or the MultiCrew team. |
| `under-review` | [search][search-copilot-label-under-review] | [search][search-multicrew-label-under-review] | Pull requests being reviewed by maintainers or the MultiCrew team. |
| `requires-changes` | [search][search-copilot-label-requires-changes] | [search][search-multicrew-label-requires-changes] | Pull requests which need to be updated based on review comments and then reviewed again. |
| `needs-testing` | [search][search-copilot-label-needs-testing] | [search][search-multicrew-label-needs-testing] | Pull requests which need manual testing. |

[search-copilot-label-enhancement]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aenhancement
[search-multicrew-label-enhancement]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aenhancement
[search-copilot-label-bug]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Abug
[search-multicrew-label-bug]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Abug
[search-copilot-label-question]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aquestion
[search-multicrew-label-question]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aquestion
[search-copilot-label-feedback]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Afeedback
[search-multicrew-label-feedback]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Afeedback
[search-copilot-label-help-wanted]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Ahelp-wanted
[search-multicrew-label-help-wanted]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Ahelp-wanted
[search-copilot-label-beginner]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Abeginner
[search-multicrew-label-beginner]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Abeginner
[search-copilot-label-more-information-needed]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Amore-information-needed
[search-multicrew-label-more-information-needed]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Amore-information-needed
[search-copilot-label-needs-reproduction]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aneeds-reproduction
[search-multicrew-label-needs-reproduction]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aneeds-reproduction
[search-copilot-label-triage-help-needed]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Atriage-help-needed
[search-multicrew-label-triage-help-needed]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Atriage-help-needed
[search-copilot-label-windows]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Awindows
[search-multicrew-label-windows]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Awindows
[search-copilot-label-linux]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Alinux
[search-multicrew-label-linux]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Alinux
[search-copilot-label-mac]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Amac
[search-multicrew-label-mac]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Amac
[search-copilot-label-documentation]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Adocumentation
[search-multicrew-label-documentation]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Adocumentation
[search-copilot-label-performance]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aperformance
[search-multicrew-label-performance]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aperformance
[search-copilot-label-security]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Asecurity
[search-multicrew-label-security]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Asecurity
[search-copilot-label-ui]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aui
[search-multicrew-label-ui]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aui
[search-copilot-label-api]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aapi
[search-multicrew-label-api]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aapi
[search-copilot-label-crash]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Acrash
[search-multicrew-label-crash]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Acrash
[search-copilot-label-auto-indent]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aauto-indent
[search-multicrew-label-auto-indent]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aauto-indent
[search-copilot-label-encoding]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aencoding
[search-multicrew-label-encoding]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aencoding
[search-copilot-label-network]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Anetwork
[search-multicrew-label-network]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Anetwork
[search-copilot-label-uncaught-exception]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Auncaught-exception
[search-multicrew-label-uncaught-exception]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Auncaught-exception
[search-copilot-label-git]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Agit
[search-multicrew-label-git]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Agit
[search-copilot-label-blocked]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Ablocked
[search-multicrew-label-blocked]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Ablocked
[search-copilot-label-duplicate]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aduplicate
[search-multicrew-label-duplicate]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aduplicate
[search-copilot-label-wontfix]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Awontfix
[search-multicrew-label-wontfix]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Awontfix
[search-copilot-label-invalid]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Ainvalid
[search-multicrew-label-invalid]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Ainvalid
[search-copilot-label-package-idea]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Apackage-idea
[search-multicrew-label-package-idea]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Apackage-idea
[search-copilot-label-wrong-repo]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Awrong-repo
[search-multicrew-label-wrong-repo]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Awrong-repo
[search-copilot-label-editor-rendering]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aeditor-rendering
[search-multicrew-label-editor-rendering]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aeditor-rendering
[search-copilot-label-build-error]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Abuild-error
[search-multicrew-label-build-error]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Abuild-error
[search-copilot-label-error-from-pathwatcher]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aerror-from-pathwatcher
[search-multicrew-label-error-from-pathwatcher]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aerror-from-pathwatcher
[search-copilot-label-error-from-save]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aerror-from-save
[search-multicrew-label-error-from-save]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aerror-from-save
[search-copilot-label-error-from-open]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aerror-from-open
[search-multicrew-label-error-from-open]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aerror-from-open
[search-copilot-label-installer]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Ainstaller
[search-multicrew-label-installer]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Ainstaller
[search-copilot-label-auto-updater]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Aauto-updater
[search-multicrew-label-auto-updater]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Aauto-updater
[search-copilot-label-deprecation-help]: https://github.com/search?q=is%3Aopen+is%3Aissue+repo%3AMultiCrew%2Fcopilot+label%3Adeprecation-help
[search-multicrew-label-deprecation-help]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Adeprecation-help
[search-copilot-label-laravel]: https://github.com/search?q=is%3Aissue+repo%3AMultiCrew%2Fcopilot+is%3Aopen+label%3Alaravel
[search-multicrew-label-laravel]: https://github.com/search?q=is%3Aopen+is%3Aissue+user%3AMultiCrew+label%3Alaravel
[search-copilot-label-work-in-progress]: https://github.com/search?q=is%3Aopen+is%3Apr+repo%3AMultiCrew%2Fcopilot+label%3Awork-in-progress
[search-multicrew-label-work-in-progress]: https://github.com/search?q=is%3Aopen+is%3Apr+user%3AMultiCrew+label%3Awork-in-progress
[search-copilot-label-needs-review]: https://github.com/search?q=is%3Aopen+is%3Apr+repo%3AMultiCrew%2Fcopilot+label%3Aneeds-review
[search-multicrew-label-needs-review]: https://github.com/search?q=is%3Aopen+is%3Apr+user%3AMultiCrew+label%3Aneeds-review
[search-copilot-label-under-review]: https://github.com/search?q=is%3Aopen+is%3Apr+repo%3AMultiCrew%2Fcopilot+label%3Aunder-review
[search-multicrew-label-under-review]: https://github.com/search?q=is%3Aopen+is%3Apr+user%3AMultiCrew+label%3Aunder-review
[search-copilot-label-requires-changes]: https://github.com/search?q=is%3Aopen+is%3Apr+repo%3AMultiCrew%2Fcopilot+label%3Arequires-changes
[search-multicrew-label-requires-changes]: https://github.com/search?q=is%3Aopen+is%3Apr+user%3AMultiCrew+label%3Arequires-changes
[search-copilot-label-needs-testing]: https://github.com/search?q=is%3Aopen+is%3Apr+repo%3AMultiCrew%2Fcopilot+label%3Aneeds-testing
[search-multicrew-label-needs-testing]: https://github.com/search?q=is%3Aopen+is%3Apr+user%3AMultiCrew+label%3Aneeds-testing

[beginner]:https://github.com/search?utf8=%E2%9C%93&q=is%3Aopen+is%3Aissue+label%3Abeginner+label%3Ahelp-wanted+user%3AMultiCrew+sort%3Acomments-desc
[help-wanted]:https://github.com/search?q=is%3Aopen+is%3Aissue+label%3Ahelp-wanted+user%3AMultiCrew+sort%3Acomments-desc+-label%3Abeginner
