import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
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
        const activeElement = event.target.parentElement.previousSibling;
        activeElement.replaceChildren(value);
        const select = activeElement.parentElement.previousSibling;
        // const attribute = select.getAttribute("name");
        // const test = activeElement.nextSibling;
        // if (attribute) {
        //     const attributeIndex = attribute.substring(
        //         attribute.indexOf(),
        //         attribute.lastIndexOf("[")
        //     );
        //     const newAttribute = attributeIndex + "[" + value + "]";
        //     select.setAttribute("name", newAttribute);
        // }
        select.setAttribute("value", value);

        this.showHideSelect("", activeElement.nextSibling);
    }
}
