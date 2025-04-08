const start = document.getElementById('start');
const stop = document.getElementById('stop');
const reset = document.getElementById('reset');
const timer = document.getElementById('timer');

let timeleft = 1500; // 25 minutes en secondes
let interval;
let isBreak = false; // Variable pour savoir si on est en pause

const updatetimer = () => {
    const minutes = Math.floor(timeleft / 60);
    const seconds = timeleft % 60;
    timer.innerHTML = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
};

const startTimer = () => {
    if (interval) return; // Empêche le démarrage multiple
    interval = setInterval(() => {
        timeleft--;
        updatetimer();

        if (timeleft <= 0) {
            clearInterval(interval);
            interval = null;

            if (!isBreak) {
                alert("⏳ Travail terminé ! Prenez une pause de 5 minutes.");
                timeleft = 300; // 5 minutes de pause
                isBreak = true;
            } else {
                alert("✅ Pause terminée ! Reprenez votre travail.");
                timeleft = 1500; // 25 minutes de travail
                isBreak = false;
            }

            updatetimer();
            startTimer(); // Redémarrer automatiquement après la transition
        }
    }, 1000);
};

const stopTimer = () => {
    clearInterval(interval);
    interval = null;
};

const resetTimer = () => {
    stopTimer();
    timeleft = 1500; // Réinitialisation à 25 minutes
    isBreak = false;
    updatetimer();
};

start.addEventListener('click', startTimer);
stop.addEventListener('click', stopTimer);
reset.addEventListener('click', resetTimer);

updatetimer(); // Mise à jour initiale
