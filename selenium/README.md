# Selenium Automated Testing

This directory contains automated testing scripts, test suites, and test cases for **Software Engineering Lab**, focusing on browser automation, functional testing, and UI validation of web applications (including the PHP/MySQL CRUD system).

---

## Testing Objectives

- **Element Locators**: Locating DOM elements via `ID`, `Name`, `XPath`, `CSS Selector`, and `Class Name`.
- **Form Automation**: Inputting text, submitting forms, dropdown selection, checkbox/radio interactions.
- **UI & Functional Verification**: Asserting page titles, table row counts, validation messages, and post-submission data updates.
- **End-to-End (E2E) Workflows**: Testing full user flows (e.g., student creation, teacher assignment, record search, and deletion).

---

## Prerequisites & Installation

### Option 1: Python Setup (Recommended)

1. Ensure Python 3.8+ is installed.
2. Install Selenium and WebDriver Manager:
   ```bash
   pip install selenium webdriver-manager pytest
   ```

### Option 2: Java Setup

1. Java JDK 11+ and Maven / Gradle or standalone JARs:
   - `selenium-java`
   - Test framework: `JUnit` or `TestNG`

---

## Sample Test Script (Python)

Create a test script `test_crud_app.py`:

```python
import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

# Initialize Chrome driver
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))

try:
    # 1. Open the CRUD Home Page
    driver.get("http://localhost/Software-Engineering-Lab/php/index.php")
    driver.maximize_window()
    time.sleep(1)

    # 2. Verify Page Title
    print("Page Title:", driver.title)
    assert "CRUD" in driver.title or len(driver.title) > 0

    # 3. Locate and click on the 'student' Read link
    student_read_link = driver.find_element(By.LINK_TEXT, "Read")
    student_read_link.click()
    time.sleep(1)

    # 4. Search for a record
    search_box = driver.find_element(By.NAME, "q")
    search_box.send_keys("CSE")
    search_box.submit()
    time.sleep(1)

    print("Test completed successfully!")

finally:
    driver.quit()
```

---

## Common Element Locator Strategies

| Method | Example Syntax |
| :--- | :--- |
| **By ID** | `driver.find_element(By.ID, "username")` |
| **By Name** | `driver.find_element(By.NAME, "dept")` |
| **By Class** | `driver.find_element(By.CLASS_NAME, "btn-submit")` |
| **By XPath** | `driver.find_element(By.XPATH, "//button[@type='submit']")` |
| **By CSS Selector** | `driver.find_element(By.CSS_SELECTOR, "table tr td")` |
| **By Link Text** | `driver.find_element(By.LINK_TEXT, "Create")` |

---

## Running Test Suites

Run via PyTest for structured reporting:

```bash
pytest test_crud_app.py -v
```
