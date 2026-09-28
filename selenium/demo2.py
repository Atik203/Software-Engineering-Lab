from selenium import webdriver
from selenium.webdriver.edge.service import Service
from selenium.webdriver.common.by import By

options= webdriver.EdgeOptions()
options.add_experimental_option("detach", True)
service_obj=Service()

driver=webdriver.Edge(options=options, service=service_obj)
driver.maximize_window()

driver.get("https://rahulshettyacademy.com/angularpractice/")
driver.find_element(By.CLASS_NAME, "form-control").send_keys("Sidratul Tanzila Tasmi")
driver.find_element(By.NAME, "email").send_keys("tanzila@cse.uiu.ac.bd")
driver.find_element(By.ID, "exampleInputPassword1").send_keys("123456")
driver.find_element(By.ID, "exampleCheck1").click()
driver.find_element(By.ID, "exampleFormControlSelect1").send_keys("Female")
driver.find_element(By.ID, "inlineRadio1").click()
driver.find_element(By.NAME, "bday").send_keys("21052026")
