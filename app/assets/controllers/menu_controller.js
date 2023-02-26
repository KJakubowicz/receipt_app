import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        this.setUserInfo();
        this.setActiveElement();
    }

    showHideList(event) {
        const menuElement = event.target.previousSibling.previousElementSibling;
        this.openCloseList(menuElement);
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

    setActiveElement() {
        const pathname = location.pathname;
        const menuElements =
            document.getElementsByClassName("menu-child-links");

        for (let index = 0; index < menuElements.length; index++) {
            const element = menuElements[index];
            const elementHref = element.getAttribute("href");
            if (elementHref === pathname) {
                element.setAttribute(
                    "class",
                    "element-child-1 menu-child-links active"
                );
                this.openCloseList(element.parentElement);
            }
        }
    }

    openCloseList(element) {
        const display = element.style.display;
        const arrow = element.previousElementSibling.lastChild.previousSibling;
        let style = "flex";
        let arrowClass = "fa-solid fa-caret-up";

        if (display === "flex") {
            style = "none";
            arrowClass = "fa-solid fa-caret-down";
        }

        element.style.display = style;
        arrow.setAttribute("class", arrowClass);
    }
}
