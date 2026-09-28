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

time.sleep(2)

driver.find_element(By.CLASS_NAME, 'forgot-password-link').click()
time.sleep(2)

driver.find_element(By.CSS_SELECTOR, 'input[type="email"]').send_keys("0112310298@gmail.com")
time.sleep(1)

heading = driver.find_element(By.CLASS_NAME, "card-title").text
print(driver.title)
print(heading)
time.sleep(1)


driver.back()
time.sleep(2)
print("After back : ",driver.title)

driver.find_element(By.ID,"userEmail").send_keys("0112310298@gmail.com")
time.sleep(1)
driver.find_element(By.ID, 'userPassword').send_keys("Ab#12345")    
time.sleep(1)

driver.find_element(By.ID,'login').click()
time.sleep(5)

driver.find_element(By.CLASS_NAME,"blinkingText").click()
time.sleep(2)