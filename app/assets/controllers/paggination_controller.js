import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
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
