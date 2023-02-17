import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        const divSelect = this;
        const options = document.getElementsByTagName("option");
        const selects = document.getElementsByTagName("select");
        this.hideSelects(selects);
        this.prepareStructure(options);
    }

    hideSelects(selects) {
        for (let index = 0; index < selects.length; index++) {
            selects[index].style.display = "none";
        }
    }

    prepareStructure(options) {
        const div = document.createElement("div");
        div.setAttribute("class", "select-content");
        let span = document.createElement("span");
        for (let index = 0; index < options.length; index++) {
            const element = options[index];
            let divChild = document.createElement("div");
            let span = document.createElement("span");
            let value = element.value;
            divChild.setAttribute("class", "select-child");
            span.append(value);
            divChild.append(span);
            div.append(divChild);
            this.element.appendChild(div);
        }
        this.element.appendChild(div);
    }
}
