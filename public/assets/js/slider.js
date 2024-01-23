const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const btnSelesai = document.querySelectorAll('.btnSelesai')
const mainSlider = document.getElementById('slider')
let antrians = []
function nextAntrian(id, btn = null) {
    antrians = document.querySelectorAll('.card-slider-item')
    let itemSlider = antrians[0]
    fetch('/admin/daftar-antrian/' + id + '/update-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    }).then(response => {
        if (btn) {
            btn.classList.remove('disabled')
        }
        if (!response.ok || response == null) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }).then(data => {
        if (itemSlider) {
            mainSlider.appendChild(itemSlider)
            itemSlider.remove()
        }
    })
}
btnSelesai.forEach(btn => {
    btn.addEventListener('click', function(){
        const id = btn.dataset.antrian
        btn.classList.add('disabled')
        btn.innerText = 'Tunggu...'
        nextAntrian(id)
    })
})
setInterval(() => {
    fetch('/admin/daftar-antrian/currents', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    }).then(response => {
        if (!response.ok || response == null) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    }).then(data => {
        data.forEach((item, index) => {
            if (!mainSlider.querySelector('#item'+item.id)) {
                let nomor = item.no_antrian.toString().length == 1 ? '00' + item.no_antrian : (item.no_antrian.toString().length == 2 ? '0' + item.no_antrian : item.no_antrian)
                let newItem = `<div class="card-slider-item" id="item${item.id}">
                    <div class="card-slider-item-label">${nomor}</div>
                    <div class="card-slider-item-content">
                        <div class="item-title">${nomor}</div>
                        <div class="item-content row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class="m-0">Nama Pasien</p>
                                    <strong>${item.pasien.name}</strong>
                                </div>
                                <div class="mb-3">
                                    <p class="m-0">Alamat</p>
                                    <strong>${item.pasien.alamat}</strong>
                                </div>
                                <div class="mb-3">
                                    <p class="m-0">Tanggal Lahir</p>
                                    <strong>${item.pasien.birtday}</strong>
                                </div>
                                <div class="mb-3">
                                    <p class="m-0">No Telepon</p>
                                    <strong>${item.pasien.phone}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <p class="m-0">Tanggal Antrian</p>
                                    <strong>${item.tanggal}</strong>
                                </div>
                                <div class="mb-3">
                                    <p class="m-0">Jenis Poli</p>
                                    <strong>${item.jenis_poli}</strong>
                                </div>
                                <div>
                                    <p class="m-0">Tipe Pasien</p>
                                    <strong>${item.tipe_pasien}</strong>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-app-primary px-3 rounded-pill" id="btnSelesai${item.id}" data-antrian="${item.id}" type="button">Tandai Selesai</button>
                    </div>
                </div>`
                mainSlider.insertAdjacentHTML('beforeend', newItem);
                const btnSelesaiSec = document.getElementById('btnSelesai' + item.id)
                btnSelesaiSec.addEventListener('click', function(){
                    const id = btnSelesaiSec.dataset.antrian
                    btnSelesaiSec.classList.add('disabled')
                    nextAntrian(id)
                })
            }
        })
    })
}, 2000)