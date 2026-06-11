import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def run_calculator_tests():
    driver = webdriver.Chrome()
    driver.maximize_window()
    wait = WebDriverWait(driver, 10)
    base_url = "http://campusconnect.test"

    try:
        # login
        print("➤ Logging in for Calculator Tests...")
        driver.get(f"{base_url}/login")
        wait.until(EC.presence_of_element_located((By.ID, "email"))).send_keys("nahid@mail.com")
        driver.find_element(By.ID, "password").send_keys("1234")
        driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        time.sleep(2)

        # cgpa calc
        print("\n➤ Testing CGPA Calculator...")
        driver.get(f"{base_url}/calculator/cgpa")
        wait.until(EC.presence_of_element_located((By.ID, "prev-credits"))).send_keys("60")
        driver.find_element(By.ID, "prev-cgpa").send_keys("3.50")
        time.sleep(2)
        
        final_cgpa = driver.find_element(By.ID, "res-cgpa").text
        print(f"✓ CGPA Result: {final_cgpa}")
        assert final_cgpa != "0.00", "CGPA Calculation Failed!"

        # tution fee calc
        print("\n➤ Testing Tuition Fee Calculator...")
        driver.get(f"{base_url}/calculator/tuition")
        
        # fresh credit in
        wait.until(EC.presence_of_element_located((By.ID, "fresh-credits"))).send_keys("9")
        
        # scholarship
        dropdown = driver.find_element(By.ID, "scholarship-pct")
        dropdown.click()
        driver.find_element(By.XPATH, "//option[@value='25']").click() # 25%
        
        time.sleep(2)
        total_fee = driver.find_element(By.ID, "res-total").text
        print(f"✓ Tuition Net Payable: {total_fee} BDT")
        assert total_fee != "0", "Tuition Calculation Failed!"

        print("\n★★★ CALCULATOR TESTS PASSED ★★★")

    except Exception as e:
        print(f"✗ Error: {e}")
    finally:
        time.sleep(3)
        driver.quit()

if __name__ == "__main__":
    run_calculator_tests()