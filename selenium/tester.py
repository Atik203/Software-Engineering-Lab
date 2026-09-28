from selenium.webdriver import ChromeOptions
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

# Service Class
service = Service()

# Chrome Options
options = ChromeOptions()

# add_experimental_option("detach", True) makes browser stay open after script execution
options.add_experimental_option("detach", True)

driver = webdriver.Chrome(service=service, options=options)

driver.maximize_window()

driver.get("https://google.com")
print("Page Title:", driver.title)

