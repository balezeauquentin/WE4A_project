(function(){
    let currentPage = 1;
    const prevBtn = document.getElementById('prevBtn');
	const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    function movePage(){
        prevBtn.disabled = false;
        nextBtn.disabled = false;
        if(currentPage === 1){
            prevBtn.disabled = true;
        } else if(currentPage === 3){
            nextBtn.disabled = true;
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
            nextBtn.disabled = false;
        }
        const stepNode = document.querySelector(".steps .step");
        const width = ((currentPage-1)*stepNode.offsetWidth*-1)+"px";
        stepNode.parentNode.style.marginLeft = width;
    }

    prevBtn.addEventListener("click",function(){
        currentPage -= 1;
        movePage();
    });

    nextBtn.addEventListener("click",function(){
        if(currentPage === 3){
            this.name = "confirm";
		}else {
			currentPage += 1;
			movePage();
		}
    });
})();