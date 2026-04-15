import axios from "axios";


const baseURL = import.meta.env.VITE_API_URL;
export const api = axios.create({
  baseURL,
  headers: { "Content-Type": "application/json" },
});

// Optional: global error helper
export function handleApiError(err : any) {
  if (err.response?.data?.message) return err.response.data.message;
  return err.message || "API error";
}