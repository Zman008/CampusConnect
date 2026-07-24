import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

def run_academic_hub_tests():
    driver = webdriver.Chrome()
    driver.maximize_window()
    wait = WebDriverWait(driver, 10)
    base_url = "http://campusconnect.test"

    try:
        # login
        print("➤ Logging in for Academic Hub Tests...")
        driver.get(f"{base_url}/login")
        wait.until(EC.presence_of_element_located((By.ID, "email"))).send_keys("nahid@mail.com")
        driver.find_element(By.ID, "password").send_keys("1234")
        driver.find_element(By.CSS_SELECTOR, "button[type='submit']").click()
        time.sleep(2)

        # ----class link
        print("\n➤ Testing Class Links Search...")
        driver.get(f"{base_url}/academic-hub/class-links")
        
        # search
        search_box = wait.until(EC.presence_of_element_located((By.ID, "courseSearch")))
        search_box.send_keys("Calculus")
        print("✓ Searching for 'Calculus'...")
        
        time.sleep(2)
        
        # filtering check
        cards = driver.find_elements(By.CLASS_NAME, "course-card")
        visible_cards = [card for card in cards if card.is_displayed()]
        print(f"✓ Number of visible courses after search: {len(visible_cards)}")
        
        assert len(visible_cards) > 0, "Search result is empty!"

        print("\n★★★ ACADEMIC HUB TESTS PASSED ★★★")

    except Exception as e:
        print(f"✗ Error: {e}")
    finally:
        time.sleep(3)
        driver.quit()

if __name__ == "__main__":
    run_academic_hub_tests()