import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    connect() {
        this.changeCount();
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
