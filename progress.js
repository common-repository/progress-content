document.addEventListener('DOMContentLoaded', () => {
    let progressBar = document.querySelectorAll('#__progress_bar_front');
    if (progressBar.length > 0) {
        progressBar = progressBar[0];
        window.addEventListener('scroll', (el) => {
            let scroll = window.scrollY;
            let height = document.body.scrollHeight - window.innerHeight;
            let progress = (scroll / height) * 100;
            progressBar.style.width = progress + '%';
        });
    }
});