<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;
use Illuminate\Http\Request;
use App\Models\Pasar;
use App\Models\Kategori;
use App\Models\BotChatLog;
use App\Models\Komoditi;
use App\Models\ProdukKomoditi;
use App\Models\RiwayatHargaKomoditi;

class TelegramBotController extends Controller
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function setWebhook()
    {
        $url = env('TELEGRAM_WEBHOOK_URL');
        $webhookUrl = $url . '/telegram/webhook/' . env('TELEGRAM_BOT_TOKEN');

        try {
            $response = $this->telegram->setWebhook(['url' => $webhookUrl]);
            return ['message' => 'Set Webhook is successful.'];
        } catch (\Exception $e) {
            return ['message' => 'Failed to set webhook.', 'error' => $e->getMessage()];
        }
    }

    public function webhook($token, Request $request)
    {
        if ($token !== env('TELEGRAM_BOT_TOKEN')) {
            return response()->json(['status' => 'Unauthorized'], 401);
        }

        $update = $request->all();
        if (isset($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = strtolower($message['text'] ?? '');

            $conversation = BotChatLog::firstOrNew(['chat_id' => $chatId]);

            if ($text === '/start') {
                $conversation->status = 'active';
                $conversation->mode = 'default';
                $conversation->save();
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Pilihan apa yang kau inginkan?\n(-) Pasar\n(-) Kategori\n(-) Komoditi\n(-) Produk Komoditi\n(X) Exit\n"
                ]);
            } elseif ($text === 'exit') {
                $conversation->status = 'inactive';
                $conversation->mode = 'off';
                $conversation->save();
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Percakapan telah berakhir.'
                ]);
            } elseif($text === 'return'){
                //$conversation->status = 'inactive';
                $conversation->mode = 'default';
                $conversation->selected_pasar = '';
                $conversation->save();

                $returnMessage = "Percakapan telah berakhir.\n\nPilihan apa yang kau inginkan?\n(-) Pasar\n(-) Kategori\n(-) Komoditi\n(-) Produk Komoditi\n(X) Exit\n";
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $returnMessage
                ]);
            // Status bot active, mulai activity
            } elseif ($conversation->status === 'active') {
                if ($text === 'pasar') {
                    $pasars = Pasar::all();
                    $namaPasar = $pasars->pluck('nama_pasar')->implode("\n");
    
                    $this->telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Daftar Pasar:\n" . $namaPasar . "\n\nKetik nama pasar untuk melihat detailnya."
                    ]);
    
                    // Mengubah mode ke pemilihan pasar
                    $conversation->mode = 'pilih_pasar';
                    $conversation->save();
                } elseif ($conversation->mode === 'pilih_pasar') {
                    $this->handlePasarDetail($chatId, $text);
                } elseif ($conversation->mode === 'detail_pasar') {
                    if ($text === 'detail') {
                        $this->showPasarDetail($chatId, $conversation->selected_pasar);
                    } elseif ($text === 'komoditi') {
                        $this->showPasarKomoditi($chatId, $conversation->selected_pasar);
                    } else {
                        $this->telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => "Perintah tidak dikenali. Pilih opsi:\n(-) Detail\n(-) Komoditi\n(-) Exit"
                        ]);
                    }

                // Command untuk Kategori
                } elseif ($text === 'kategori') {
                    $kategoris = Kategori::all();
                    $namaKategori = $kategoris->pluck('nama_kategori')->implode("\n");

                    $this->telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Daftar Kategori:\n" . $namaKategori
                    ]);

                    $conversation->mode = 'default';
                    $conversation->save();

                // Command untuk Komoditi
                } elseif ($text === 'komoditi') {
                    $komoditis = Komoditi::all();
                    $jenisKomoditi = $komoditis->pluck('jenis_komoditi')->implode("\n");

                    $this->telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Daftar Komoditi:\n" . $jenisKomoditi
                    ]);

                    $conversation->mode = 'default';
                    $conversation->save();

                // Command untuk Produk Komoditi     
                } elseif ($text === 'produk komoditi' || $text === 'produk') {
                    $produks = ProdukKomoditi::all();
                    $namaProduk = $produks->pluck('nama_produk')->implode("\n");

                    $this->telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => "Daftar Produk:\n" . $namaProduk
                    ]);

                    $conversation->mode = 'pilih_produk';
                    $conversation->save();

                // Ubah mode ke dalam pilih produk
                } elseif ($conversation->mode === 'pilih_produk') {
                    $this->showHargaProduk($chatId, $text);
                } else {
                    // Menangani input lain jika mode tidak dikenali
                    $this->telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'Perintah tidak dikenali.'
                    ]);
                }
            } elseif($text === '/help'){
                $helpMessage = "\"/start\" Akan menampilkan tampilan:\nPilihan apa yang kau inginkan?\n(-) Pasar\n(-) Kategori\n(-) Komoditi\n(-) Produk Komoditi\n(-) Riwayat Harga\n(X) Exit
                            \nAnda dapat memasukkan \"pasar\" atau \"Pasar\" untuk memilih pilihan pasar. Hal ini juga berlaku untuk opsi kategori dan seterusnya.
                            \nTerdapat command /return untuk kembali ke main menu awal dan /exit untuk memberhentikan kerja bot. Setelah \"/exit\" digunakan, program akan berhenti menerima input dan user harus mengulang perintah \"/start\" agar bot dapat kembali membaca input.";
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $helpMessage,
                ]);
            } else {
                $this->telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Percakapan telah berakhir. Ketik /start untuk memulai lagi.'
                ]);
            }

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'no message'], 200);
    }

    private function handlePasarDetail($chatId, $text)
    {
        $pasar = Pasar::where('nama_pasar', 'like', '%' . $text . '%')->first();
    
        if ($pasar) {
            $conversation = BotChatLog::firstOrNew(['chat_id' => $chatId]);
            $conversation->mode = 'detail_pasar';
            $conversation->selected_pasar = $pasar->id;
            $conversation->save();

            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Pilih Opsi untuk Pasar {$pasar->nama_pasar}:\n(-) Detail\n(-) Komoditi\n(-) Return"
            ]);
        } else {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Pasar tidak ditemukan. Silakan coba lagi.'
            ]);
        }
    }

    private function showPasarDetail($chatId, $pasarId)
    {
        $pasar = Pasar::find($pasarId);
        if ($pasar) {
            $detail = "Detail Pasar:\n";
            $detail .= "Nama: " . $pasar->nama_pasar . "\n";
            $detail .= "Lokasi: " . $pasar->kota . ", " . $pasar->provinsi . "\n";

            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $detail
            ]);
        } else {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Detail pasar tidak ditemukan.'
            ]);
        }
    }

    private function showPasarKomoditi($chatId, $pasarId)
    {
        $produkKomoditis = ProdukKomoditi::select(
            'produk_komoditi.nama_produk', 
            'komoditi.jenis_komoditi', 
            'riwayat_harga_komoditi.harga', 
            'riwayat_harga_komoditi.tanggal_update')
        ->join('riwayat_harga_komoditi', 'produk_komoditi.id', '=', 'riwayat_harga_komoditi.produk_komoditi_id')
        ->join('pasar', 'riwayat_harga_komoditi.pasar_id', '=', 'pasar.id')
        ->join('komoditi', 'produk_komoditi.komoditi_id', '=', 'komoditi.id')
        ->where('pasar.id', $pasarId)
        ->whereIn('riwayat_harga_komoditi.id', function($query) {
            $query->selectRaw('MAX(id)')
                ->from('riwayat_harga_komoditi')
                ->groupBy('produk_komoditi_id', 'pasar_id');
        })
        ->orderBy('produk_komoditi.nama_produk')
        ->get();

        $pasar = Pasar::select('nama_pasar')->where('id', $pasarId)->first();
        $pasarName = $pasar->nama_pasar;

        if ($produkKomoditis->isNotEmpty()) {
            $detailKomoditi = "Daftar Produk Komoditi dan Harga Terbaru di {$pasarName}:\n";
            foreach ($produkKomoditis as $produk) {
                $detailKomoditi .= "Nama Produk: " . $produk->nama_produk . "\n";
                $detailKomoditi .= "Jenis: " . $produk->jenis_komoditi . "\n";
                $detailKomoditi .= "Harga: " . $produk->harga . "\n";
                $detailKomoditi .= "Tanggal Update: " . $produk->tanggal_update . "\n\n";
            }

            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $detailKomoditi
            ]);
        } else {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Belum ada produk komoditi yang ditemukan di pasar ini.'
            ]);
        }
    }

    private function showHargaProduk($chatId, $namaProduk)
    {
        $produkKomoditi = ProdukKomoditi::select('id')
            ->where('nama_produk', $namaProduk)
            ->first();

        if (!$produkKomoditi) {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => "Produk komoditi dengan nama '{$namaProduk}' tidak ditemukan."
            ]);
            return;
        }

        $riwayatHarga = RiwayatHargaKomoditi::select(
                'pasar.nama_pasar', 
                'riwayat_harga_komoditi.harga', 
                'riwayat_harga_komoditi.tanggal_update'
            )
            ->join('pasar', 'riwayat_harga_komoditi.pasar_id', '=', 'pasar.id')
            ->where('riwayat_harga_komoditi.produk_komoditi_id', $produkKomoditi->id)
            ->whereIn('riwayat_harga_komoditi.tanggal_update', function($query) {
                $query->selectRaw('MAX(sub.tanggal_update)')
                    ->from('riwayat_harga_komoditi as sub')
                    ->whereColumn('sub.produk_komoditi_id', 'riwayat_harga_komoditi.produk_komoditi_id')
                    ->whereColumn('sub.pasar_id', 'riwayat_harga_komoditi.pasar_id')
                    ->groupBy('sub.produk_komoditi_id', 'sub.pasar_id');
            })
            ->orderBy('pasar.nama_pasar')
            ->get();

        if ($riwayatHarga->isNotEmpty()) {
            $detailHarga = "Harga terbaru untuk produk komoditi '{$namaProduk}' di berbagai pasar:\n";
            foreach ($riwayatHarga as $riwayat) {
                $detailHarga .= "Pasar: " . $riwayat->nama_pasar . "\n";
                $detailHarga .= "Harga: " . $riwayat->harga . "\n";
                $detailHarga .= "Tanggal Update: " . $riwayat->tanggal_update . "\n\n";
            }

            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $detailHarga
            ]);
        } else {
            $this->telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Tidak ada harga produk komoditi yang ditemukan di pasar-pasar.'
            ]);
        }

        // Kembalikan mode ke default setelah menampilkan harga produk
        $conversation = BotChatLog::firstOrNew(['chat_id' => $chatId]);
        $conversation->mode = 'default';
        $conversation->save();
    }
}