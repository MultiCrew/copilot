# Project Management

:+1::tada: Welcome to the official Copilot repository, MultiCrew's primary project :tada::+1:

The following is a description of how MultiCrew's software development projects are managed using GitHub, hosted in the [MultiCrew Organization](https://github.com/MultiCrew).

## GitHub Projects

We use [GitHub Projects](https://github.com/MultiCrew/copilot/projects) to track our development roadmap. There are four columns of project 'cards': To do, In progress, Done and Long-term features. The first three columns use automation to track their progress automatically, whilst the fourth column is for the MultiCrew team to add longer-term ideas which are not at the stage of being prioritised and implemented.

#### Issues

Every new feature, enhancement, bug report, etc. comes to the project as an [Issue](https://github.com/MultiCrew/copilot/issues). There are templates for creating new issues for both bug reports and feature requests. When Issues are created by the community, one of the MutliCrew team members will address the issue initially by assigning it [labels](https://github.com/MultiCrew/copilot/labels) and a [milestone](https://github.com/MultiCrew/copilot/milestones), adding it to the GitHub project To do column, and possibly also assigning a team member who will be responsilbe for seeing the issue through to its closure.

In some cases, more information is required before an Issue can be properly considered and prioritised in the project. These are given the [label `more-information-needed`](https://github.com/MultiCrew/copilot/labels/more-information-needed).

#### Pull Requests

An Issue will be addressed as part of an existing branch or in a new branch for the specific Issue. When some progress has been made with addressing the Issue, a draft Pull Request may be created, with the [`work-in-progress` label](https://github.com/MultiCrew/copilot/labels/work-in-progress) (as well as any relevant labels from each Issue addressed by it). It should also be linked to the Issue(s) it closes, using [linking keywords](https://help.github.com/en/github/managing-your-work-on-github/linking-a-pull-request-to-an-issue#linking-a-pull-request-to-an-issue-using-a-keyword), and given the last milestone of the Issue(s). Any linked Issues should be **manually removed from the project** as they are now addressed by the Pull Request, and the Pull Request added to the project - this will automatically add the PR to the In progress column.

#### Code Review

When the Issue has been fully addressed, the Pull Request may be converted from a draft, and the `work-in-progress` label dropped in favour of the [`under-review` label](https://github.com/MultiCrew/copilot/labels/under-review). You may request a review from a specific member of the MultiCrew team, or simply leave it for anyone to pick up. Your code will be scrutinised, and you can expect changes to be requested for your first few. Reviewers can highlight specific lines or whole methods and should explain what they suggest should be changed, and why. Code authors should then discuss these changes and, where appropriate, modify their branch, re-requesting a review until their changes are approved.

Once the changes have been approved by a review, the `under-review` label is dropped and the PR merged. The relevant branch may be deleted, depending on whether more changes are expected directly related to the PR and/or Issues just addressed in the near future or not.

## Tracking the Project

There are several ways you can track the project's progress on GitHub.

#### Release Tags

MultiCrew's software uses [Semantic Versioning](https://semver.org/) to number its releases. All pre-release (alpha testing) versions come under the `0.x.x` tag whilst the initial release will be prefixed `1.x.x`. First release tags may be suffixed `-beta` where they are not publicly available yet.

#### Milestones

[Milestones](https://github.com/MultiCrew/copilot/milestones) are by far the easiest way to see the project's progress towards a particular release tag. Each milestone will have a description containing a basic feature/bugfix list. It will contain all of the Issues, and the PRs which address them, which must be closed before the milestone can be reached.

#### Kanban Boards

The [GitHub Project page](https://github.com/MultiCrew/copilot/projects/1) shows each Issue and PR triaged, in order of priority and organised by its progress. 

#### Labels

[Labels](https://github.com/MultiCrew/copilot/labels) allow you to track specific categories of Issues and PRs. If you are looking for a specific part of the project to contribute under, this may be helpful.
