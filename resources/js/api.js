import axios from "axios";

export default axios.create({
    baseURL: "https://partup.herokuapp.com/api",
    headers: {
        Authorization: "Bearer " + window.localStorage.getItem("authToken"),
    },
});
