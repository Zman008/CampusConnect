import http from 'k6/http';
import { sleep, check } from 'k6';

export const options = {
  vus: 10,          
  duration: '30s',  
};

const BASE_URL = 'https://campusconnect-0zxp.onrender.com';

export default function () {
  const res = http.get(`${BASE_URL}/`);
  check(res, {
    'status is 200': (r) => r.status === 200,
  });
  sleep(1);
}
