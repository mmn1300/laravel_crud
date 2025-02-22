document.addEventListener('DOMContentLoaded', () => {
    const postActions = document.querySelector('.post-actions');
    const isOwnPost = document.querySelector('.post-actions').id;
    if(isOwnPost){
        postActions.appendChild(createUDButton());
    }
    // else{
    //     postActions.appendChild(createRecommendButton());
    // }

    const number = parseInt(document.querySelector('.main-content').id);
    fileExists(number).then(fileName => {
        if(fileName !==''){
            downloadFile(fileName, number);
        }
    });
});