import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        const divSelect = this;
        const options = document.getElementsByTagName("option");
        const selects = document.getElementsByTagName("select");
        this.hideSelects(selects);
        const div = this.prepareStructure(options);
        this.element.appendChild(div);
    }

    hideSelects(selects) {
        for (let index = 0; index < selects.length; index++) {
            selects[index].style.display = "none";
        }
    }

    prepareStructure(options) {
        const div = document.createElement("div");
        div.setAttribute("class", "select-content");
        div.setAttribute("data-controller", "actions");
        div.setAttribute("data-action", "click->actions#showHideSelect");
        let span = document.createElement("span");

        const divOptionsBox = document.createElement("div");
        divOptionsBox.setAttribute("class", "select-options-box");
        divOptionsBox.setAttribute("id", "select-target");

        const divActive = document.createElement("div");
        divActive.setAttribute("class", "select-active");
        div.append(divActive);

        for (let index = 0; index < options.length; index++) {
            let position = 30 * (index + 1);
            const element = options[index];
            let divChild = document.createElement("div");
            console.log(element.textContent);
            let value = element.value;
            let content = element.textContent;
            divChild.setAttribute("class", "select-child hover-select");
            divChild.setAttribute("data-controller", "actions");
            divChild.setAttribute(
                "data-action",
                "click->actions#setSelectValue"
            );
            divChild.setAttribute("data-value", value);
            divChild.setAttribute("style", "top:" + position + "px");
            divChild.append(content);
            divOptionsBox.append(divChild);
        }
        div.append(divOptionsBox);
        return div;
    }
}
