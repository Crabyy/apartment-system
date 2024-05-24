const tokenKey = "authToken";
let authToken = sessionStorage.getItem(tokenKey);

export function checkIfUserIsAuthenticated() {
  return authToken !== null && authToken !== undefined;
}

export function simulateLogin() {
  authToken = generateAuthToken();
  sessionStorage.setItem(tokenKey, authToken);
}

export function simulateLogout() {
  authToken = null;
  sessionStorage.removeItem(tokenKey);
  sessionStorage.removeItem("userType");
  sessionStorage.removeItem("userData");
}

function generateAuthToken() {
  // Generate a secure token, you can use a library like uuid or any other method
  // For simplicity, let's use a basic example
  return Math.random().toString(36).substring(2) + Date.now().toString(36);
}
