import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        this.setUserInfo();
    }
    showHideList(event) {
        const menuElement = event.target.previousSibling.previousElementSibling;
        const display = menuElement.style.display;
        const arrow =
            menuElement.previousElementSibling.lastChild.previousSibling;
        let style = "flex";
        let arrowClass = "fa-solid fa-caret-up";

        if (display === "flex") {
            style = "none";
            arrowClass = "fa-solid fa-caret-down";
        }

        menuElement.style.display = style;
        arrow.setAttribute("class", arrowClass);
    }

    async setUserInfo() {
        const nameElement = document.getElementById("user-name");
        const emailElement = document.getElementById("user-email");
        const userData = await this.getUserInfor();

        nameElement.innerText = userData.name;
        emailElement.innerText = userData.email;
    }

    async getUserInfor() {
        const result = await fetch("http://beta.receipt.pl/api/user/get");
        const jsonData = await result.json();
        const response = JSON.parse(JSON.stringify(jsonData));
        const name = response.data.name;
        const surname = response.data.surname;
        const email = response.data.email;

        return {
            name: name + " " + surname,
            email: email,
        };
    }
}
