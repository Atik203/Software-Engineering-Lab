from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

# In Selenium 4, the executable path must be passed inside a Service object
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()))

# Note: In modern Selenium 4.6+, you can also simply write:
# driver = webdriver.Chrome()

driver.get("https://google.com")
print("Page Title:", driver.title)

driver.quit()