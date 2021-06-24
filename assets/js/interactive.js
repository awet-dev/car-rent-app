for (let i = 1; i <= 8; i++) {
    document.getElementById('question-list-'+i).addEventListener('click', function () {
        document.getElementById('arrow-up-'+i).classList.toggle('d-none');
        document.getElementById('arrow-down-'+i).classList.toggle('d-none');
    })
    console.log("this is working 8 times")
}





