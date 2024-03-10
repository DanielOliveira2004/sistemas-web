

document.getElementById('start').addEventListener('input', function(e) {
    let input = e.target.value;
    
    if (/^\d{0,2}$/.test(input)) {
        // Formato: HH
        e.target.value = input.replace(/^(\d{0,2})$/, '$1');
    } else if (/^\d{2}:?\d{0,2}$/.test(input)) {
        // Formato: HHMM
        e.target.value = input.replace(/^(\d{2}):?(\d{0,2})$/, '$1:$2');
    } else if (/^\d{2}:\d{2,}$/.test(input)) {
        // Formato: HH:MM
        e.target.value = input.replace(/^(\d{2})(\d{2})$/, '$1:$2');
    } else {
        // Formato inválido, limpa o campo
        e.target.value = '';
    }
});

document.getElementById('start').addEventListener('blur', function(e) {
    let input = e.target.value;
    if (input.length === 2 && !input.includes(':')) {
        // Se o usuário inseriu apenas as horas sem os minutos
        e.target.value = input + ':';
    }
});

document.getElementById('end').addEventListener('input', function(e) {
    let input = e.target.value;
    if (/^\d{0,2}$/.test(input)) {
        // Formato: HH
        e.target.value = input.replace(/^(\d{0,2})$/, '$1');
    } else if (/^\d{2}:?\d{0,2}$/.test(input)) {
        // Formato: HHMM
        e.target.value = input.replace(/^(\d{2}):?(\d{0,2})$/, '$1:$2');
    } else if (/^\d{2}:\d{2,}$/.test(input)) {
        // Formato: HH:MM
        e.target.value = input.replace(/^(\d{2})(\d{2})$/, '$1:$2');
    } else {
        // Formato inválido, limpa o campo
        e.target.value = '';
    }
});

document.getElementById('end').addEventListener('blur', function(e) {
    let input = e.target.value;
    if (input.length === 2 && !input.includes(':')) {
        // Se o usuário inseriu apenas as horas sem os minutos
        e.target.value = input + ':';
    }
});