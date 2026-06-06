import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time 

def run_login_tests():
    # 1. Initialize the Chrome browser session
    driver = webdriver.Chrome()
    driver.maximize_window()
    
    target_url = "http://campusconnect.test/login"
    
    try:
        # ---- TEST CASE 1: Successful Login ----
        print("Running Test Case 1: Valid Login...")
        driver.get(target_url)
        
        # Explicitly wait up to 10 seconds for inputs to be interactive
        wait = WebDriverWait(driver, 10)
        email_input = wait.until(EC.element_to_be_clickable((By.ID, "email")))
        password_input = driver.find_element(By.ID, "password")
        login_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
        
        # Act: Enter valid credentials
        email_input.send_keys("nahid@mail.com")
        time.sleep(1)  
        password_input.send_keys("1234")
        time.sleep(1)  
        login_button.click()

        time.sleep(4)  

        logout_button = wait.until(EC.element_to_be_clickable((By.ID, "logoutButton")))

        logout_button.click()
        time.sleep(2)
        
        # ---- TEST CASE 2: Failed Login ----
        print("\nRunning Test Case 2: Invalid Login...")
        # Log out or navigate back to the login page
        driver.get(target_url)
        
        # Re-locate elements since the page refreshed
        email_input = wait.until(EC.element_to_be_clickable((By.ID, "email")))
        password_input = driver.find_element(By.ID, "password")
        login_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
        
        # Act: Enter invalid credentials
        time.sleep(1)
        email_input.send_keys("wrong_user@mail.com")
        time.sleep(1)
        password_input.send_keys("wrong_password")
        time.sleep(1)
        login_button.click()
        time.sleep(1)
        
        
    except AssertionError as msg:
        print(f"✗ Assertion Failure: {msg}")
    except Exception as e:
        print(f"✗ Unexpected Error: {e}")
        
    finally:
        # Always safe-close the browser window
        print("\nClosing browser environment.")
        driver.quit()

if __name__ == "__main__":
    run_login_tests()