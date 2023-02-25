import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
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
}
