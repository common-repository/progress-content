document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelectorAll('#height_bar').length>0) {
        let px_value=document.querySelector('#px-bar');
        document.querySelector('#height_bar').addEventListener('input', (e) => {
            document.querySelector('#__progress_bar').style.height = e.target.value + 'px';
            px_value.innerText=e.target.value;
        });
        document.querySelector('#color_bar').addEventListener('change', (e) => {
            console.log("Hey", e.target.value);
            document.querySelector('#__progress_bar').style.background = e.target.value;
        });
        document.querySelector('#style_bar').addEventListener('change', (e) => {
            document.querySelector('#__progress_bar').className = e.target.value;
        });
    }
});