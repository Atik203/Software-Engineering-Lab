# Selenium Automated Testing — Quick Reference & Exam Sheet

A complete, practical guide and cheat sheet for **Software Engineering Lab Class Tests (CT)** and exams on automated testing using Python and Selenium WebDriver.

---

## Table of Contents
1. [Driver Setup & Browser Launch (Chrome & Edge)](#1-driver-setup--browser-launch)
2. [Browser Commands & Navigation](#2-browser-commands--navigation)
3. [The 8 Locator Strategies](#3-the-8-locator-strategies)
4. [CRITICAL EXAM TRAPS & GOTCHAS](#4-critical-exam-traps--gotchas)
5. [Automating Common Form Elements](#5-automating-common-form-elements)
6. [Form Submission & Validation](#6-form-submission--validation)
7. [Dropdowns (Select Class)](#7-dropdowns-select-class)
8. [Handling JavaScript Alerts & Popups](#8-handling-javascript-alerts--popups)
9. [Waits (Implicit vs Explicit)](#9-waits-implicit-vs-explicit)
10. [Full End-to-End Exam Template](#10-full-end-to-end-exam-template)

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
driver.get("https://rahulshettyacademy.com/angularpractice/")
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
| **Tag Name** | `driver.find_element(By.TAG_NAME, "form")` | `<form>...</form>` |
| **Link Text** | `driver.find_element(By.LINK_TEXT, "Shop")` | `<a href="/shop">Shop</a>` |
| **Partial Link**| `driver.find_element(By.PARTIAL_LINK_TEXT, "Sh")` | `<a href="/shop">Shop</a>` |

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

## 6. Form Submission & Validation

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

## 7. Dropdowns (`Select` Class)

When a dropdown uses standard HTML `<select>` and `<option>` tags, use Selenium's `Select` class:

```python
from selenium.webdriver.support.select import Select

# 1. Locate the <select> tag
dropdown_element = driver.find_element(By.ID, "exampleFormControlSelect1")
dropdown = Select(dropdown_element)

# 2. Three ways to select an option:
dropdown.select_by_visible_text("Female")   # By visible text displayed in UI
dropdown.select_by_index(1)                # By 0-based index (e.g., 0, 1, 2)
# dropdown.select_by_value("option_value") # By the 'value' HTML attribute

# Verify selection:
selected_option = dropdown.first_selected_option.text
print("Selected:", selected_option)
assert selected_option == "Female"
```

---

## 8. Handling JavaScript Alerts & Popups

For standard browser dialogs (`window.alert()`, `window.confirm()`, `window.prompt()`):

```python
# Trigger the alert in the web app first, then switch to it:
alert = driver.switch_to.alert

print("Alert text:", alert.text)

# Click 'OK' on alert / confirm
alert.accept()

# Click 'Cancel' on confirm dialog
# alert.dismiss()

# Type into a prompt dialog:
# alert.send_keys("My Name")
# alert.accept()
```

---

## 9. Waits (Implicit vs Explicit)

Avoid using `time.sleep()` in production code. Use Selenium waits instead:

### Implicit Wait (Global timeout for all elements)
```python
# Tells driver to wait up to 10 seconds before throwing NoSuchElementException
driver.implicitly_wait(10)
```

### Explicit Wait (Targeted conditional wait)
```python
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

# Wait up to 10 seconds until the success banner is visible in the DOM
wait = WebDriverWait(driver, 10)
success_alert = wait.until(
    EC.visibility_of_element_located((By.CLASS_NAME, "alert-success"))
)
print("Alert appeared:", success_alert.text)
```

---

## 10. Full End-to-End Exam Template

Here is a complete, working script automating the **ProtoCommerce Angular Practice Form** with all assertions:

```python
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.select import Select

# 1. Setup options
options = webdriver.ChromeOptions()
options.add_experimental_option("detach", True)

# 2. Launch browser
driver = webdriver.Chrome(options=options)
driver.maximize_window()
driver.implicitly_wait(5)

try:
    # 3. Navigate
    driver.get("https://rahulshettyacademy.com/angularpractice/")
    assert "ProtoCommerce" in driver.title

    # 4. Fill text fields
    driver.find_element(By.NAME, "name").send_keys("Atikur Rahaman")
    driver.find_element(By.NAME, "email").send_keys("atikur@example.com")
    driver.find_element(By.ID, "exampleInputPassword1").send_keys("SecretPass123")

    # 5. Checkbox
    checkbox = driver.find_element(By.ID, "exampleCheck1")
    if not checkbox.is_selected():
        checkbox.click()

    # 6. Dropdown (Gender)
    gender_dropdown = Select(driver.find_element(By.ID, "exampleFormControlSelect1"))
    gender_dropdown.select_by_visible_text("Male")

    # 7. Radio button (Employment Status: Student)
    driver.find_element(By.ID, "inlineRadio1").click()

    # 8. Date of birth
    driver.find_element(By.NAME, "bday").send_keys("15082002")

    # 9. Submit the form
    driver.find_element(By.CSS_SELECTOR, "input[type='submit']").click()

    # 10. Verify submission alert
    alert_box = driver.find_element(By.CLASS_NAME, "alert-success")
    print("Submission Result:\n", alert_box.text)
    assert "Success!" in alert_box.text

    print("\n✅ Test Passed Successfully!")

finally:
    # driver.quit()
    pass
```
