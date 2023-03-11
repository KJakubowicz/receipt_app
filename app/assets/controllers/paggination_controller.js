import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        this.changeCount();
        this.prepareLinks();
    }
    prepareLinks() {
        const pagginationParent = document.getElementById("paggination-pages");
        const perPageParent = document.getElementById("per-page-list");
        const params = new URLSearchParams(document.location.search);
        if (pagginationParent.hasChildNodes()) {
            this.setPagginationLinks(pagginationParent, params);
        }
        if (perPageParent.hasChildNodes()) {
            this.setPerPageLinks(perPageParent, params);
        }
    }
    setPerPageLinks(parent, params) {
        const children = parent.children;

        for (let index = 0; index < children.length; index++) {
            const element = children[index];
            const currentParams =
                "?per_page=" + element.getAttribute("data-per-page");
            element.setAttribute("href", currentParams);
        }
    }
    setPagginationLinks(parent, params) {
        const children = parent.children;
        const paramName = "page";
        let actualParams = "";
        let i = 1;
        params.forEach((value, key) => {
            if (paramName !== key) {
                if (i === 1) {
                    actualParams += "?" + key + "=" + value;
                } else {
                    actualParams += "&" + key + "=" + value;
                }
                i++;
            }
        });
        for (let index = 0; index < children.length; index++) {
            const element = children[index];
            const currentParams =
                actualParams + "&page=" + element.getAttribute("data-page");
            element.setAttribute("href", currentParams);
        }
    }
    changeCount() {
        const element = document.getElementById("per-page-count");
        const count = parseInt(element.textContent);
        const params = new URLSearchParams(document.location.search);
        const perPage = params.get("per_page");

        if (perPage && count !== perPage) {
            element.textContent = perPage;
        }
    }

    showList(event) {
        const element = document.getElementById("per-page-list");
        const visable = getComputedStyle(element).display;
        let display = "none";

        if (visable === "none") {
            display = "flex";
        }

        element.style.display = display;
    }
}
