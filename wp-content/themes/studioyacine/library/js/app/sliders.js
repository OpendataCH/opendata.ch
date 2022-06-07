import Flickity from "flickity";

export default class Sliders {
    constructor() {
        this.els = document.querySelectorAll(".slider");
		this.init();
    }

    init() {
		if(this.els){
			for (let i = 0; i < this.els.length; i++) {
				this.flkty = new Flickity(this.els[i], {
					cellAlign: "left",
					groupCells: true,
					pageDots: false
				});
			}
		}
    }
}

const slider = new Sliders();
