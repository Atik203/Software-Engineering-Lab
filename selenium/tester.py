from selenium.webdriver import ChromeOptions
from selenium import webdriver
from selenium.webdriver.chrome.service import Service

# Service Class
service = Service()

# Chrome Options
options = ChromeOptions()

# add_experimental_option("detach", True) makes browser stay open after script execution
options.add_experimental_option("detach", True)

driver = webdriver.Chrome(service=service, options=options)

driver.maximize_window()

driver.get("https://google.com")
print("Page URL", driver.current_url)

driver.get('https://youtube.com')
print("Current URL", driver.current_url)

driver.back()
print("Current URL", driver.current_url)

driver.forward()
print("Current URL", driver.current_url)


driver.refresh()
print("Current URL", driver.current_url)


