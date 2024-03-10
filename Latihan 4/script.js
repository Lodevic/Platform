document.getElementById('submitBtn').addEventListener('click', function() {
    var jumlah = parseInt(document.getElementById('jumlah').value);
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
                return;
            } else {
                selectedOptions.push(input.value.trim()); // Menambahkan nilai teks ke dalam array
            }
        });

        if (allInputsFilled) {
            optionsDiv.innerHTML = '';

            var pilihanLabel = document.createElement('label');
            pilihanLabel.textContent = 'Pilihan :';
            optionsDiv.appendChild(pilihanLabel);

            var pilihanSelect = document.createElement('select');
            pilihanSelect.name = 'pilihan';
            pilihanSelect.id = 'selectedOption'; // Menambahkan id ke dropdown

            // Menambahkan opsi ke dalam dropdown
            selectedOptions.forEach(function(optionValue) {
                var option = document.createElement('option');
                option.value = optionValue;
                option.text = optionValue;
                pilihanSelect.appendChild(option);
            });

            optionsDiv.appendChild(pilihanSelect);

            // Menambahkan pesan ke dalam div message
            var messageDiv = document.querySelector('.message');
            var nama = document.getElementById('nama').value;
            var jml = jumlah;

            // Menambahkan event listener untuk tombol Submit di dalam tombol "Submit" sebelumnya
            pilihanSelect.addEventListener('change', function() {
                var selectedOption = this.value; // Mengambil nilai yang dipilih dari dropdown
                var message = "Hallo, nama saya " + nama + ", saya mempunyai sejumlah " + jml + " pilihan yaitu " + selectedOptions.join(", ") + ", dan saya memilih " + selectedOption;
                messageDiv.textContent = message;
                messageDiv.style.display = 'block'; // Menampilkan pesan
            });

            // Menambahkan tombol untuk memperbarui halaman
            var reloadButton = document.createElement('button');
            reloadButton.textContent = 'Refresh Halaman';
            reloadButton.addEventListener('click', function() {
                location.reload(); // Memuat ulang halaman
            });
            messageDiv.appendChild(reloadButton);
        } else {
            alert('Silakan isi semua teks pilihan terlebih dahulu.');
        }
    });
    var refreshButton = document.getElementById('refreshBtn');
refreshButton.addEventListener('click', function() {
    location.reload(); // Memuat ulang halaman
});
});
