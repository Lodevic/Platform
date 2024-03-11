document.getElementById('submitBtn').addEventListener('click', function() {
    var namaInput = document.getElementById('nama');
    var jumlahInput = document.getElementById('jumlah');

    // Memeriksa apakah nama atau jumlah kosong
    if (namaInput.value.trim() === '') {
        namaInput.classList.add('error'); // Menambahkan class error pada input nama
    } else {
        namaInput.classList.remove('error'); // Menghapus class error pada input nama jika sudah diisi
    }

    if (jumlahInput.value.trim() === '') {
        jumlahInput.classList.add('error'); // Menambahkan class error pada input jumlah
    } else {
        jumlahInput.classList.remove('error'); // Menghapus class error pada input jumlah jika sudah diisi
    }

    // Memeriksa apakah ada input yang masih kosong
    if (namaInput.value.trim() === '' || jumlahInput.value.trim() === '') {
        alert('Silakan isi semua kolom dengan benar.');
        return; // Menghentikan eksekusi fungsi jika ada input yang kosong
    }

    // Validasi jika input jumlah tidak dapat diubah menjadi bilangan bulat atau lebih kecil dari 1
    var jumlah = parseInt(jumlahInput.value.trim());
    if (isNaN(jumlah) || jumlah < 1 || jumlah != jumlahInput.value.trim()) {
        alert('Silakan masukkan jumlah pilihan dalam bilangan bulat yang lebih besar dari 0.');
        return;
    }

    var optionsDiv = document.querySelector('.options');
    optionsDiv.innerHTML = '';

    for (var i = 1; i <= jumlah; i++) {
        var label = document.createElement('label');
        label.textContent = 'Pilihan ' + i + ' :';
        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'pilihan_' + i;
        input.required = true;
        optionsDiv.appendChild(label);
        optionsDiv.appendChild(input);
    }

    var submitFinalButton = document.createElement('input');
    submitFinalButton.type = 'button'; // Mengubah tipe tombol menjadi "button"
    submitFinalButton.value = 'Submit';
    optionsDiv.appendChild(submitFinalButton);
    
    optionsDiv.style.display = 'block';
    
    // Menghilangkan tombol "OK" setelah memasukkan jumlah pilihan
    this.style.display = 'none';

    // Menentukan apakah tombol "OK" akan memiliki gaya error
    var okButton = this;
    if (namaInput.value.trim() === '' || jumlahInput.value.trim() === '') {
        okButton.style.color = '#ff0000'; // Mengubah warna teks menjadi merah
        okButton.style.fontStyle = 'italic'; // Miringkan teks
    } else {
        okButton.style.color = ''; // Menghapus gaya warna teks
        okButton.style.fontStyle = ''; // Menghapus gaya miring
    }

    // Menonaktifkan input nama dan jumlah setelah tombol "OK" ditekan
    namaInput.disabled = true;
    jumlahInput.disabled = true;
    
    // Setelah dropdown dipilih dan tombol Submit ditekan
    submitFinalButton.addEventListener('click', function(event) {
        event.preventDefault();
        
        var allInputsFilled = true;
        var selectedOptions = []; // Untuk menyimpan nilai teks dari input pilihan
        var pilihanLabels = document.querySelectorAll('.options label');
        pilihanLabels.forEach(function(label) {
            var input = label.nextElementSibling;
            if (input.value.trim() === '') {
                allInputsFilled = false;
                label.classList.add('error'); // Menambahkan class error pada label
                return;
            } else {
                label.classList.remove('error'); // Menghapus class error pada label jika sudah diisi
                selectedOptions.push(input.value.trim()); // Menambahkan nilai teks ke dalam array
            }
        });

        if (!allInputsFilled) {
            alert('Silakan isi semua teks pilihan terlebih dahulu.');
            return;
        }

        optionsDiv.innerHTML = '';

        var pilihanLabel = document.createElement('label');
        pilihanLabel.textContent = 'Pilihan :';
        optionsDiv.appendChild(pilihanLabel);

        var pilihanSelect = document.createElement('select');
        pilihanSelect.name = 'pilihan';
        pilihanSelect.id = 'selectedOption'; // Menambahkan id ke dropdown

        // Menambahkan opsi ke dalam dropdown
        // Tambahkan opsi default yang tidak terlihat pada dropdown
        var defaultOption = document.createElement('option');
        defaultOption.value = ''; // Kosongkan nilai value
        defaultOption.text = 'Pilih salah satu'; // Teks yang akan ditampilkan
        defaultOption.selected = true; // Jadikan default terpilih
        defaultOption.disabled = true; // Buat opsi tidak dapat dipilih
        pilihanSelect.appendChild(defaultOption);

        selectedOptions.forEach(function(optionValue) {
            var option = document.createElement('option');
            option.value = optionValue; // Menambahkan nilai untuk setiap opsi
            option.text = optionValue;
            pilihanSelect.appendChild(option);
        });

        optionsDiv.appendChild(pilihanSelect);

        // Menambahkan pesan ke dalam div message
        var messageDiv = document.querySelector('.message');
        var nama = namaInput.value;
        var jml = jumlah;

        // Menambahkan event listener untuk tombol Submit di dalam tombol "Submit" sebelumnya
        pilihanSelect.addEventListener('change', function() {
            var selectedOption = this.value; // Mengambil nilai yang dipilih dari dropdown
            var message = "Hallo, nama saya " + nama + ", saya mempunyai sejumlah " + jml + " pilihan yaitu " + selectedOptions.join(", ") + ", dan saya memilih " + selectedOption;
            messageDiv.textContent = message;
            messageDiv.style.display = 'block'; // Menampilkan pesan
        });
    });    
});
