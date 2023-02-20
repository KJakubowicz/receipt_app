import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static activeId;

    showHideSelect(event = "", element = "") {
        let optionsBox = "";
        if (element === "") {
            const target = event.target;
            optionsBox = document.getElementById("select-target");
        } else {
            optionsBox = element;
        }
        const selectContent = optionsBox.parentElement;
        const visable = getComputedStyle(optionsBox).display;
        let display = "none";
        let selectClass = "select-content";

        if (visable === "none") {
            display = "flex";
            selectClass = "select-content opened";
        }
        optionsBox.style.display = display;
        selectContent.setAttribute("class", selectClass);
    }

    setSelectValue(event) {
        const value = event.target.getAttribute("data-value");
        const id = event.target.getAttribute("data-id");
        const textContent = value ? event.target.textContent : "";
        const activeElement = event.target.parentElement.previousSibling;
        activeElement.replaceChildren(textContent);
        const select = activeElement.parentElement.previousSibling;
        select.setAttribute("value", value);
        const children = select.children;
        for (let index = 0; index < children.length; index++) {
            let element = children[index];
            element.removeAttribute("selected");
        }
        const selectedOption = document.getElementById(id);
        selectedOption.setAttribute("selected", "selected");
        this.showHideSelect("", activeElement.nextSibling);
    }
}
