import axios from "axios";

export default axios.create({
    headers: {
        Authorization: "Bearer " + window.localStorage.getItem("authToken"),
    },
});
