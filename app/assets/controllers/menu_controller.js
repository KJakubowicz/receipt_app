import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    showHideList(event) {
        const display =
            event.target.previousSibling.previousElementSibling.style.display;

        const style = display === "flex" ? "none" : "flex";
        event.target.previousSibling.previousElementSibling.style.display =
            style;
    }
}
