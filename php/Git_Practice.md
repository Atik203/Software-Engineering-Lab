# GIT Practice — Full Solutions

All commands below were actually run in a real Git repository to verify correctness and capture real output. Where Git's real behavior differs from what the question implies (e.g., commits require an email even if the question says "email not needed"), that's called out explicitly.

---

# QUESTION 1

## Problem 1: Initialize and Configure Git

**Task:** Create a folder `ExamRepo`, configure Git name/email, initialize as a repo, show status.

```bash
mkdir ExamRepo
cd ExamRepo
git init
git config user.name "Atikur Rahaman"
git config user.email "atikur@example.com"
git status
```

**Output of `git status`:**

```
On branch master

No commits yet

nothing to commit (create/copy files and use "git add" to track)
```

> **Note:** `git init` should come before `git config` (config just sets values in `.git/config` — order between init and config doesn't technically matter, but doing `init` first is the natural order since the folder must be a repo before `.git/config` exists to write into).

---

## Problem 2: Tracking Files and Creating Commits

**Task:** Create `notes.txt` with text, check status, stage, commit, show history.

```bash
echo "Git is a version control system." > notes.txt
git status
```

**Output:**

```
On branch master

No commits yet

Untracked files:
  (use "git add <file>..." to include in what will be committed)
	notes.txt

nothing added to commit but untracked files present (use "git add" to track)
```

```bash
git add notes.txt
git commit -m "Added notes.txt"
git log
```

**Output:**

```
[master (root-commit) 4ac96b4] Added notes.txt
 1 file changed, 1 insertion(+)
 create mode 100644 notes.txt

commit 4ac96b45cb8bc268fbfc2e68045cc36f15fcf56c
Author: Atikur Rahaman <atikur@example.com>
Date:   Mon Aug 31 2026

    Added notes.txt
```

---

## Problem 3: Modifying Files and Using Reset

**Task:** Add a second line, commit, view history, reset to first commit, show the line is gone.

```bash
echo "Branches allow parallel development." >> notes.txt
git add notes.txt
git commit -m "Updated notes.txt with branches info"
git log --oneline
```

**Output:**

```
4be035c Updated notes.txt with branches info
4ac96b4 Added notes.txt
```

```bash
git reset --hard 4ac96b4
cat notes.txt
```

**Output:**

```
HEAD is now at 4ac96b4 Added notes.txt
Git is a version control system.
```

The second line is removed — `git reset --hard <commit>` moves the branch pointer back **and** rewrites the working directory to match that commit, discarding the later commit entirely.

> **Tip:** Replace `4ac96b4` with whichever commit hash `git log` shows you for the first commit — hashes are unique to each repo instance.

---

## Problem 4: Creating and Switching Branches

**Task:** Create branch `feature-update`, switch to it, create `update.txt`, commit, show branch log.

```bash
git branch feature-update
git checkout feature-update
echo "This is a feature update." > update.txt
git add update.txt
git commit -m "Added update.txt"
git log --oneline
```

**Output:**

```
Switched to branch 'feature-update'
[feature-update 6fc5ee5] Added update.txt
 1 file changed, 1 insertion(+)
 create mode 100644 update.txt

6fc5ee5 Added update.txt
4ac96b4 Added notes.txt
```

> You could also do steps 1–2 in one command: `git checkout -b feature-update`.

---

## Problem 5: Merging Branches

**Task:** Switch to master, show `update.txt` doesn't exist there, merge `feature-update`, show it now exists, show updated log.

```bash
git checkout master
ls
```

**Output:**

```
Switched to branch 'master'
notes.txt
```

`update.txt` is **not** present on master — confirmed.

```bash
git merge feature-update -m "Merge feature-update into master"
ls
```

**Output:**

```
Updating 4ac96b4..6fc5ee5
Fast-forward (no commit created; -m option ignored)
 update.txt | 1 +
 1 file changed, 1 insertion(+)
 create mode 100644 update.txt

notes.txt
update.txt
```

`update.txt` now exists on master. Notice Git reports **"Fast-forward"** — since master had no new commits since `feature-update` branched off, Git just moved master's pointer forward (no new merge commit created).

```bash
git log --oneline --graph --all
```

**Output:**

```
* 6fc5ee5 Added update.txt
* 4ac96b4 Added notes.txt
```

Linear history — a signature of a fast-forward merge.

---

## Problem 6: Creating Another Branch and Simulating Parallel Work

**Task:** Create `design-change`, edit `notes.txt` there, switch to master and edit `notes.txt` differently there too, then merge and observe.

```bash
git branch design-change
git checkout design-change
echo "This line was added on the design-change branch." >> notes.txt
git add notes.txt
git commit -m "Add design-change line to notes.txt"
```

**Output:**

```
Switched to branch 'design-change'
[design-change 72aa269] Add design-change line to notes.txt
 1 file changed, 1 insertion(+)
```

```bash
git checkout master
echo "This line was added on the main branch." >> notes.txt
git add notes.txt
git commit -m "Add main branch line to notes.txt"
```

**Output:**

```
Switched to branch 'master'
[master 320a87c] Add main branch line to notes.txt
 1 file changed, 1 insertion(+)
```

```bash
git merge design-change
```

**Output — a MERGE CONFLICT occurs:**

```
Auto-merging notes.txt
CONFLICT (content): Merge conflict in notes.txt
Automatic merge failed; fix conflicts and then commit the result.
```

```bash
git status
```

**Output:**

```
On branch master
You have unmerged paths.
  (fix conflicts and run "git commit")
  (use "git merge --abort" to abort the merge)

Unmerged paths:
  (use "git add <file>..." to mark resolution)
	both modified:   notes.txt
```

```bash
cat notes.txt
```

**Output — Git inserts conflict markers directly into the file:**

```
Git is a version control system.
<<<<<<< HEAD
This line was added on the main branch.
=======
This line was added on the design-change branch.
>>>>>>> design-change
```

**Explanation:** Both branches modified the **same line region** of `notes.txt` independently since their common ancestor. Because Git can't automatically decide which version is "correct," it stops the merge and marks the conflicting section with `<<<<<<<`, `=======`, `>>>>>>>` markers. To resolve: manually edit the file to keep the desired content (or both lines), remove the conflict markers, then run:

```bash
git add notes.txt
git commit -m "Resolve merge conflict in notes.txt"
```

---

# QUESTION 2

## Problem 1: Setup and First Commit

**Task:** Create `ProjectAlpha`, init, configure username only, create `readme.md`, commit, show history.

```bash
mkdir ProjectAlpha
cd ProjectAlpha
git init
git config user.name "Atikur Rahaman"
echo "This is Project Alpha." > readme.md
git add readme.md
git commit -m "Initial commit with readme.md"
```

**Important real-world gotcha:** Git actually **requires both a name and an email** to create a commit — even though the question says "email not needed for this question." If you skip the email, `git commit` fails with:

```
*** Please tell me who you are.

Run

  git config --global user.email "you@example.com"
  git config --global user.name "Your Name"

fatal: unable to auto-detect email address (got 'root@vm.(none)')
```

So in practice you must still set _some_ email (or already have a global one configured) for the commit to succeed — "email not needed" only makes sense if a global email is already set on your machine from a previous `--global` configuration, so this local repo doesn't need to set it again.

```bash
git log --oneline
```

**Output:**

```
[master (root-commit) 62b99d1] Initial commit with readme.md
 1 file changed, 1 insertion(+)
 create mode 100644 readme.md

62b99d1 Initial commit with readme.md
```

---

## Problem 2: Multiple Files and History Tracking

**Task:** Create `app.txt` and `info.txt`, stage only `app.txt`, check status, commit separately.

```bash
echo "Application content." > app.txt
echo "Information content." > info.txt
git add app.txt
git status
```

**Output — notice the difference between staged and untracked:**

```
On branch master
Changes to be committed:
  (use "git restore --staged <file>..." to unstage)
	new file:   app.txt

Untracked files:
  (use "git add <file>..." to include in what will be committed)
	info.txt
```

`app.txt` shows under **"Changes to be committed"** (staged), while `info.txt` shows under **"Untracked files"** (not staged) — this is the key difference the question asks you to observe.

```bash
git commit -m "Added app.txt"
git add info.txt
git commit -m "Added info.txt"
git log --oneline
```

**Output:**

```
c3e5abe Added info.txt
07e3f5d Added app.txt
62b99d1 Initial commit with readme.md
```

**Explanation:** There are **3 commits total**:

1. `62b99d1` — Initial commit adding `readme.md`
2. `07e3f5d` — Adds `app.txt` only
3. `c3e5abe` — Adds `info.txt` only

Each commit represents one atomic, meaningful change staged and committed separately — this is best practice (one logical change per commit) rather than bundling unrelated files into a single commit.

---

## Problem 3: Reverting to a Previous Version

**Task:** Edit `readme.md`, commit, note the first commit ID, reset to it, confirm `app.txt`/`info.txt` are gone and `readme.md` reverted.

```bash
echo "Updated project description." >> readme.md
git add readme.md
git commit -m "Updated readme.md with project description"
git log --oneline
```

**Output:**

```
59048c3 Updated readme.md with project description
c3e5abe Added info.txt
07e3f5d Added app.txt
62b99d1 Initial commit with readme.md
```

First commit ID: `62b99d1`

```bash
git reset --hard 62b99d1
ls
```

**Output:**

```
HEAD is now at 62b99d1 Initial commit with readme.md
readme.md
```

Confirmed: **`app.txt` and `info.txt` are both removed** — only `readme.md` remains, since `git reset --hard` rewrites the working directory to exactly match the target commit's state.

```bash
cat readme.md
```

**Output:**

```
This is Project Alpha.
```

Confirmed: the "Updated project description." line is gone — `readme.md` is back to its original content from the first commit.

---

## Problem 4: Creating Branches for New Features

**Task:** Create `documentation` branch, switch, recreate `info.txt`, commit, verify the commit exists only on this branch.

```bash
git branch documentation
git checkout documentation
echo "Documentation in progress." > info.txt
git add info.txt
git commit -m "Added info.txt with documentation progress"
```

**Output:**

```
Switched to branch 'documentation'
[documentation 058c85c] Added info.txt with documentation progress
 1 file changed, 1 insertion(+)
 create mode 100644 info.txt
```

```bash
git log --oneline
```

**Output (on `documentation` branch):**

```
058c85c Added info.txt with documentation progress
62b99d1 Initial commit with readme.md
```

```bash
git log --oneline master
```

**Output (on `master` branch) — verify the commit does NOT appear here:**

```
62b99d1 Initial commit with readme.md
```

Confirmed: the `058c85c` commit exists **only** in the `documentation` branch's history, not in `master`'s.

---

## Problem 5: Branch Modification & Merge

**Task:** Switch to master, create `feature-ui`, add `ui.txt`, commit, then merge both `documentation` and `feature-ui` into master.

```bash
git checkout master
git branch feature-ui
git checkout feature-ui
echo "Initial UI layout." > ui.txt
git add ui.txt
git commit -m "Added ui.txt with initial layout"
```

**Output:**

```
Switched to branch 'master'
Switched to branch 'feature-ui'
[feature-ui 5ef4965] Added ui.txt with initial layout
 1 file changed, 1 insertion(+)
 create mode 100644 ui.txt
```

```bash
git checkout master
git merge documentation -m "Merge documentation into master"
```

**Output:**

```
Switched to branch 'master'
Updating 62b99d1..058c85c
Fast-forward (no commit created; -m option ignored)
 info.txt | 1 +
 1 file changed, 1 insertion(+)
 create mode 100644 info.txt
```

This is a **fast-forward** merge — master hadn't changed since `documentation` was created.

```bash
git merge feature-ui -m "Merge feature-ui into master"
```

**Output:**

```
Merge made by the 'ort' strategy.
 ui.txt | 1 +
 1 file changed, 1 insertion(+)
 create mode 100644 ui.txt
```

This is a **true three-way merge** (a real merge commit created via the `ort` strategy) — because master had _just_ advanced via the previous merge, Git treats this as a genuine divergence needing a merge commit, unlike the pure fast-forward above.

```bash
ls
```

**Output:**

```
info.txt
readme.md
ui.txt
```

Confirmed: both `info.txt` and `ui.txt` now exist in master.

---

## Problem 6: Parallel Changes and Merge Behavior

**Task:** Edit `readme.md` on master, edit `readme.md` differently on the already-merged `feature-ui`, then attempt to merge `feature-ui` into master again.

```bash
echo "Main branch update." >> readme.md
git add readme.md
git commit -m "Add main branch update to readme.md"
```

**Output:**

```
[master a8b523f] Add main branch update to readme.md
 1 file changed, 1 insertion(+)
```

```bash
git checkout feature-ui
echo "UI branch update." >> readme.md
git add readme.md
git commit -m "Add UI branch update to readme.md"
```

**Output:**

```
Switched to branch 'feature-ui'
[feature-ui 29fb7e1] Add UI branch update to readme.md
 1 file changed, 1 insertion(+)
```

```bash
git checkout master
git merge feature-ui
```

**Output — CONFLICT again:**

```
Switched to branch 'master'
Auto-merging readme.md
CONFLICT (content): Merge conflict in readme.md
Automatic merge failed; fix conflicts and then commit the result.
```

```bash
git status
```

**Output:**

```
On branch master
You have unmerged paths.
  (fix conflicts and run "git commit")
  (use "git merge --abort" to abort the merge)

Unmerged paths:
  (use "git add <file>..." to mark resolution)
	both modified:   readme.md
```

**Explanation:** Even though `feature-ui` was already merged into master once (for `ui.txt`), Git doesn't refuse to merge it again — the branches have **since diverged further**: master got a new commit ("Main branch update") and `feature-ui` got a different new commit ("UI branch update"), both touching the **same file and same region** (`readme.md`). Since Git can't automatically reconcile two different edits to the same line, it stops and reports a **merge conflict**, requiring manual resolution — exactly the same mechanism as in Question 1, Problem 6. This shows that "already merged once" does **not** mean two branches can never conflict again — each new set of divergent commits is evaluated independently at merge time.

---
