import axios from "axios";

// Create an Axios instance with default settings
const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL, // Use the base URL from .env file
  headers: {
    "Content-Type": "application/json", // Set the content type to JSON
  },
});

// Add a request interceptor to include Authorization token in request headers
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token"); // Get the token from local storage
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`; // Add token to Authorization header
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Add a response interceptor for handling errors globally
api.interceptors.response.use(
  (response) => response, // If response is successful, just return it
  (error) => {
    // Handle response error (e.g., token expiration or invalid token)
    if (error.response.status === 401) {
      // Handle unauthorized error (e.g., redirect to login)
      localStorage.removeItem("token");
      window.location.href = "/login"; // Redirect to login page
    }
    return Promise.reject(error); // Return the error to the calling function
  }
);

export default api;
