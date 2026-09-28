# Selenium Automated Testing — Quick Reference & Exam Sheet

A complete, practical guide and cheat sheet for **Software Engineering Lab Class Tests (CT)** and exams on automated testing using Python and Selenium WebDriver.

---

## Table of Contents
1. [Driver Setup & Browser Launch (Chrome & Edge)](#1-driver-setup--browser-launch)
2. [Browser Commands & Navigation](#2-browser-commands--navigation)
3. [The 8 Locator Strategies](#3-the-8-locator-strategies)
4. [CRITICAL EXAM TRAPS & GOTCHAS](#4-critical-exam-traps--gotchas)
5. [Automating Common Form Elements](#5-automating-common-form-elements)
6. [Dropdowns & Select Controls (Static & Dynamic)](#6-dropdowns--select-controls)
7. [Form Submission & Validation](#7-form-submission--validation)
8. [Handling JavaScript Alerts & Popups](#8-handling-javascript-alerts--popups)
9. [Handling Multiple Windows & Tabs](#9-handling-multiple-windows--tabs)
10. [Handling Frames & iFrames](#10-handling-frames--iframes)
11. [Mouse Actions & Hover (ActionChains)](#11-mouse-actions--hover-actionchains)
12. [Waits (Implicit vs Explicit)](#12-waits-implicit-vs-explicit)
13. [Exam Problem 1: RahulShetty Client Portal (Login, Forgot Password, Navigation)](#13-exam-problem-1-rahulshetty-client-portal)
14. [Exam Problem 2: ProtoCommerce Angular Form (Full UI Controls Automation)](#14-exam-problem-2-protocommerce-angular-form)

---

## 1. Driver Setup & Browser Launch

### A. Google Chrome Setup

```python
from selenium import webdriver
from selenium.webdriver.chrome.service import Service

# Keep browser open after script finishes
options = webdriver.ChromeOptions()
options.add_experimental_option("detach", True)

# Option 1: Modern Selenium (Selenium 4.6+ built-in manager - Recommended)
driver = webdriver.Chrome(options=options)

# Option 2: Using Service object explicitly
# service = Service()
# driver = webdriver.Chrome(service=service, options=options)
```

### B. Microsoft Edge Setup

```python
from selenium import webdriver
from selenium.webdriver.edge.service import Service

options = webdriver.EdgeOptions()
options.add_experimental_option("detach", True)
service = Service()

driver = webdriver.Edge(service=service, options=options)
```

> [!CAUTION]
> **Case-Sensitivity Warning:**
> - `webdriver.Chrome` (Capital **C**) is the **class** constructor.
> - `webdriver.chrome` (lowercase **c**) is a **submodule**. Writing `webdriver.chrome()` causes:
>   `TypeError: 'module' object is not callable`.

---

## 2. Browser Commands & Navigation

```python
# Window sizing
driver.maximize_window()
driver.minimize_window()

# Navigation
driver.get("https://rahulshettyacademy.com/client")
print("Page Title:", driver.title)
print("Current URL:", driver.current_url)

driver.get("https://google.com")
driver.back()          # Go back to previous page
driver.forward()       # Go forward
driver.refresh()       # Reload the page

# Cleanup
driver.close()         # Closes ONLY the active browser tab
driver.quit()          # Kills the entire browser process and closes all tabs
```

---

## 3. The 8 Locator Strategies

Import the `By` class first:
```python
from selenium.webdriver.common.by import By
```

| Locator | Code Syntax | Example HTML Target |
| :--- | :--- | :--- |
| **ID** | `driver.find_element(By.ID, "exampleInputPassword1")` | `<input id="exampleInputPassword1">` |
| **Name** | `driver.find_element(By.NAME, "email")` | `<input name="email">` |
| **Class Name** | `driver.find_element(By.CLASS_NAME, "form-control")` | `<input class="form-control">` |
| **CSS Selector** | `driver.find_element(By.CSS_SELECTOR, "input[type='submit']")` | `<input type="submit">` |
| **XPath** | `driver.find_element(By.XPATH, "//input[@value='Submit']")` | `<input value="Submit">` |
| **Tag Name** | `driver.find_element(By.TAG_NAME, "h3")` | `<h3>Enter New Password</h3>` |
| **Link Text** | `driver.find_element(By.LINK_TEXT, "Forgot password?")` | `<a href="...">Forgot password?</a>` |
| **Partial Link**| `driver.find_element(By.PARTIAL_LINK_TEXT, "Forgot")` | `<a href="...">Forgot password?</a>` |

---

## 4. CRITICAL EXAM TRAPS & GOTCHAS

### Trap 1: Compound Class Names (Spaces in Class)
Given HTML: `<input class="btn btn-success" type="submit" value="Submit">`

- ❌ **DO NOT DO THIS:**
  ```python
  driver.find_element(By.CLASS_NAME, "btn btn-success")
  # 💥 CRASHES: InvalidSelectorException: Compound class names are not allowed!
  ```
- ✅ **Option A (Use a single unique class):**
  ```python
  driver.find_element(By.CLASS_NAME, "btn-success").click()
  ```
- ✅ **Option B (Use CSS Selector with dots `.` replacing spaces):**
  ```python
  driver.find_element(By.CSS_SELECTOR, ".btn.btn-success").click()
  # or with tag name:
  driver.find_element(By.CSS_SELECTOR, "input.btn-success").click()
  ```

### Trap 2: Trying to find by `value` or `type` directly
There is **NO** `By.VALUE` or `By.TYPE` in Selenium!
- ✅ **By CSS Selector:** `driver.find_element(By.CSS_SELECTOR, "input[value='Submit']")`
- ✅ **By XPath:** `driver.find_element(By.XPATH, "//input[@value='Submit']")`
- ✅ **By CSS Type:** `driver.find_element(By.CSS_SELECTOR, "input[type='submit']")`

### Trap 3: `LINK_TEXT` on Buttons
`By.LINK_TEXT` and `By.PARTIAL_LINK_TEXT` **ONLY** work on anchor tags `<a>`. They do **NOT** work on `<input type="submit" value="Submit">` or `<button>`.

### Trap 4: Angular Two-Way Binding vs Form Submission
When typing text into an Angular form, you may see text immediately displayed below under *"Two-way Data Binding example"*. **This is not submission!** The form is only submitted when the submit button is clicked and the green alert banner (`alert-success`) appears.

---

## 5. Automating Common Form Elements

```python
# 1. Text Field / Password Field
name_input = driver.find_element(By.NAME, "name")
name_input.clear()                     # Clear existing text
name_input.send_keys("Atikur Rahaman") # Type text

# 2. Checkbox
checkbox = driver.find_element(By.ID, "exampleCheck1")
if not checkbox.is_selected():
    checkbox.click()                   # Check the box

# 3. Radio Button
radio = driver.find_element(By.ID, "inlineRadio1")
radio.click()
assert radio.is_selected()             # Verify it was selected

# 4. Date Picker (<input type="date">)
bday_input = driver.find_element(By.NAME, "bday")
bday_input.send_keys("21052026")       # Sends DDMMYYYY
```

---

## 6. Dropdowns & Select Controls

### A. Static Dropdowns (`<select>` and `<option>` tags)

Use the built-in `Select` class:

```python
from selenium.webdriver.support.select import Select

# 1. Locate the <select> tag
dropdown_element = driver.find_element(By.ID, "exampleFormControlSelect1")
dropdown = Select(dropdown_element)

# 2. Three ways to select an option:
dropdown.select_by_visible_text("Female")   # By visible text on UI
dropdown.select_by_index(1)                # By 0-based index (0 is 1st, 1 is 2nd)
dropdown.select_by_value("option_value")   # By 'value' HTML attribute

# 3. Read the currently selected option:
current_text = dropdown.first_selected_option.text
print("Selected:", current_text)
assert current_text == "Female"

# 4. Iterate over all options in the dropdown:
for opt in dropdown.options:
    print("Option:", opt.text)

# 5. Multi-Select Dropdowns (if multiple='true'):
if dropdown.is_multiple:
    dropdown.select_by_visible_text("Option 1")
    dropdown.select_by_visible_text("Option 2")
    dropdown.deselect_all()  # Deselect all selections
```

---

### B. Dynamic / Auto-Suggestive Dropdowns

For search boxes that show dynamic suggestions as you type (e.g. typing `"ind"` to pick `"India"`):

```python
# 1. Type the keyword
driver.find_element(By.ID, "autosuggest").send_keys("ind")
time.sleep(2)  # Give time for AJAX suggestions to load

# 2. Grab all suggestion elements using find_elements (plural)
suggestions = driver.find_elements(By.CSS_SELECTOR, "li.ui-menu-item a")
print("Total suggestions found:", len(suggestions))

# 3. Loop through suggestions and click the target match
for option in suggestions:
    if option.text == "India":
        option.click()
        break

# 4. Verify selection (for dynamic inputs, use get_attribute('value'))
selected_val = driver.find_element(By.ID, "autosuggest").get_attribute("value")
assert selected_val == "India"
```

---

## 7. Form Submission & Validation

```python
# Submit using click on the button:
driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()

# Or submit using form element .submit():
# driver.find_element(By.NAME, "name").submit()

# Retrieve and assert success message:
success_banner = driver.find_element(By.CLASS_NAME, "alert-success")
print("Banner Text:", success_banner.text)

# Validation assertion
assert "Success!" in success_banner.text
```

---

## 8. Handling JavaScript Alerts & Popups

For standard browser popups created with `window.alert()`, `window.confirm()`, or `window.prompt()`:

```python
# 1. Trigger the alert in the web app, then switch to it:
alert = driver.switch_to.alert

# 2. Read alert text
print("Alert message:", alert.text)

# 3. Accept (Clicks 'OK')
alert.accept()

# 4. Dismiss (Clicks 'Cancel' if it's a confirmation popup)
# alert.dismiss()

# 5. Type into a prompt popup:
# alert.send_keys("My input")
# alert.accept()
```

---

## 9. Handling Multiple Windows & Tabs

When a link opens in a new tab or popup window:

```python
# 1. Get current (parent) window handle
parent_window = driver.current_window_handle

# 2. Click the link that opens a new tab/window
driver.find_element(By.LINK_TEXT, "Open New Window").click()
time.sleep(2)

# 3. Get all open window handles
all_windows = driver.window_handles  # List of window IDs

# 4. Switch to the child window (index 1)
for window in all_windows:
    if window != parent_window:
        driver.switch_to.window(window)
        break

# Now performing actions in the new tab:
print("New Window Title:", driver.title)
driver.close()  # Closes ONLY the child tab

# 5. Switch back to parent window
driver.switch_to.window(parent_window)
print("Back to Parent Window Title:", driver.title)
```

---

## 10. Handling Frames & iFrames

When elements are nested inside an `<iframe>`:

```python
# 1. Switch to frame using ID, Name, or WebElement
driver.switch_to.frame("courses-iframe")
# or: driver.switch_to.frame(driver.find_element(By.ID, "courses-iframe"))
# or by index: driver.switch_to.frame(0)

# 2. Interact with elements inside the frame
driver.find_element(By.LINK_TEXT, "All Access Plan").click()

# 3. CRITICAL: Switch back to main web page outside the frame
driver.switch_to.default_content()
```

---

## 11. Mouse Actions & Hover (ActionChains)

For hover menus, right-clicks, and double-clicks:

```python
from selenium.webdriver import ActionChains

actions = ActionChains(driver)

# 1. Mouse Hover over element
menu = driver.find_element(By.ID, "mousehover")
actions.move_to_element(menu).perform()

# 2. Click a sub-item that appears after hover
top_link = driver.find_element(By.LINK_TEXT, "Top")
actions.move_to_element(top_link).click().perform()

# 3. Right-Click (Context Click)
# actions.context_click(menu).perform()

# 4. Double Click
# actions.double_click(menu).perform()

# 5. Drag and Drop
# source = driver.find_element(By.ID, "draggable")
# target = driver.find_element(By.ID, "droppable")
# actions.drag_and_drop(source, target).perform()
```

---

## 12. Waits (Implicit vs Explicit)

### Implicit Wait (Global timeout for all elements)
```python
# Tells driver to wait up to 10 seconds before throwing NoSuchElementException
driver.implicitly_wait(10)
```

### Explicit Wait (Targeted conditional wait)
```python
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Wait up to 10 seconds until the element is visible
wait = WebDriverWait(driver, 10)
alert_box = wait.until(
    EC.visibility_of_element_located((By.CLASS_NAME, "alert-success"))
)
print("Alert appeared:", alert_box.text)
```

---

## 13. Exam Problem 1: RahulShetty Client Portal

**Faculty Question Tasks:**
1. Go to `https://rahulshettyacademy.com/client`
2. Create account manually beforehand.
3. Click "Forgot password?".
4. Enter registered email address.
5. Read & print heading/title text.
6. Return to Login page.
7. Login using email and password.
8. Click blinking green link (`blinkingText`).

```python
from selenium import webdriver
from selenium.webdriver.common.by import By
import time

options = webdriver.ChromeOptions()
options.add_experimental_option("detach", True)

driver = webdriver.Chrome(options=options)
driver.maximize_window()

EMAIL = "0112310298@gmail.com"  # Your registered student email
PASSWORD = "Ab#12345"

# Task 1: Go to website
driver.get("https://rahulshettyacademy.com/client")
print("Task 1 - Page Title:", driver.title)
time.sleep(2)

# Task 3: Click Forgot password
driver.find_element(By.CLASS_NAME, "forgot-password-link").click()
time.sleep(2)

# Task 4: Enter registered email
driver.find_element(By.CSS_SELECTOR, "input[type='email']").send_keys(EMAIL)
time.sleep(1)

# Task 5: Read and print heading & title
heading = driver.find_element(By.CLASS_NAME, "card-title").text
print("Task 5 - Page Title:", driver.title)
print("Task 5 - Heading Text:", heading)
time.sleep(1)

# Task 6: Return to Login page
driver.back()
time.sleep(2)
print("Task 6 - Returned to Login Page. Title:", driver.title)

# Task 7: Login
driver.find_element(By.ID, "userEmail").send_keys(EMAIL)
time.sleep(1)
driver.find_element(By.ID, "userPassword").send_keys(PASSWORD)
time.sleep(1)
driver.find_element(By.ID, "login").click()
time.sleep(5)  # Wait for dashboard to load

# Task 8: Click blinking green link
driver.find_element(By.CLASS_NAME, "blinkingText").click()
time.sleep(2)
print("Task 8 - Navigated to:", driver.current_url)
print("All tasks completed successfully!")
```

---

## 14. Exam Problem 2: ProtoCommerce Angular Form

**Covers: Text inputs, Select dropdown, Checkbox, Radio, Date picker, Submit, and Alert verification.**

```python
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.select import Select
import time

options = webdriver.ChromeOptions()
options.add_experimental_option("detach", True)

driver = webdriver.Chrome(options=options)
driver.maximize_window()

# 1. Navigate
driver.get("https://rahulshettyacademy.com/angularpractice/")
time.sleep(2)

# 2. Text fields
driver.find_element(By.NAME, "name").send_keys("Atikur Rahaman")
driver.find_element(By.NAME, "email").send_keys("0112310298@gmail.com")
driver.find_element(By.ID, "exampleInputPassword1").send_keys("SecretPass123")

# 3. Checkbox
checkbox = driver.find_element(By.ID, "exampleCheck1")
if not checkbox.is_selected():
    checkbox.click()

# 4. Static Dropdown (<select>)
dropdown = Select(driver.find_element(By.ID, "exampleFormControlSelect1"))
dropdown.select_by_visible_text("Female")

# 5. Radio button
driver.find_element(By.ID, "inlineRadio1").click()

# 6. Date input
driver.find_element(By.NAME, "bday").send_keys("21052002")

# 7. Submit form
driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()
time.sleep(2)

# 8. Verify alert message
alert_box = driver.find_element(By.CLASS_NAME, "alert-success")
print("Submission Result:\n", alert_box.text)
assert "Success!" in alert_box.text
print("Test Passed!")
```
