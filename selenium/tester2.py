from selenium.webdriver import ChromeOptions
from selenium.webdriver.chrome.service import Service
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
import time




service = Service()

options = ChromeOptions()
options.add_experimental_option('detach',True)


driver = webdriver.Chrome(service=service, options=options)

driver.maximize_window()


driver.get("https://rahulshettyacademy.com/client")
print("Page Title:", driver.title)
