import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    mouseOver(event) {
        event.target.style.backgroundColor = "#2828251c";
        event.target.cursor = "pointer";
        event.target.parentNode.style.display = "flex";
    }
    mouseOut(event) {
        event.target.style.backgroundColor = "";
        event.target.parentNode.style.display = "none";
    }
    showElement(event) {
        event.target.parentNode.nextSibling.nextSibling.style.display = "flex";
    }
    hideElement(event) {
        event.target.parentNode.nextSibling.nextSibling.style.display = "none";
    }
}
