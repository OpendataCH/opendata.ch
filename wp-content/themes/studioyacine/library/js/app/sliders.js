import Flickity from "flickity";

export default class Sliders {
    constructor() {
        this.el = document.querySelector(".slider");
		this.init();
    }

    init() {
		if(this.el){
			this.flkty = new Flickity(this.el, {
				cellAlign: "left",
				groupCells: true,
				pageDots: false
			});
		}
    }
}

const slider = new Sliders();
