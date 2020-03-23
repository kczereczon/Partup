import axios from "axios";

export default axios.create({
    baseURL: "http://localhost:8000/api",
    headers: {
        Authorization: "Bearer " + window.localStorage.getItem("authToken")
    }
});
