<?php

namespace App\Services;

use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PixService{

    public function gerarPix(
        string $chavePix,
        float $valor,
        string $beneficiario,
        string $cidade,
        string $descricao = '',
        string $txid = ''
    ): array {
        // Validações básicas
        if (strlen($chavePix) < 2) {
            throw new \Exception("Chave PIX inválida");
        }

        $payload = [
            '00' => '01', // Payload Format Indicator
            '26' => [
                '00' => 'BR.GOV.BCB.PIX',
                '01' => $chavePix,
                '02' => $this->limitarString($descricao, 72),
            ],
            '52' => '0000', // Merchant Category Code
            '53' => '986',  // Transaction Currency (BRL)
            '54' => number_format($valor, 2, '.', ''),
            '58' => 'BR',   // Country Code
            '59' => $this->limitarString($beneficiario, 25),
            '60' => $this->limitarString($cidade, 15),
            '62' => [
                '05' => $this->limitarString($txid, 25),
            ],
        ];

        $payloadString = $this->montarPayload($payload);
        $crc16 = $this->calcularCRC16($payloadString . '6304');
        
        $codigoPix = $payloadString . '6304' . $crc16;

        return [
            'codigo' => $codigoPix,
            'qr_code' => QrCode::size(300)->generate($codigoPix)
        ];
    }

    private function limitarString(string $str, int $tamanho): string
    {
        return mb_substr(trim($str), 0, $tamanho, 'UTF-8');
    }

    private function montarPayload(array $payload): string
    {
        $retorno = '';
        
        foreach ($payload as $id => $valor) {
            if (is_array($valor)) {
                $valor = $this->montarPayload($valor);
            }
            
            $retorno .= $this->montarCampo($id, $valor);
        }
        
        return $retorno;
    }

    private function montarCampo(string $id, string $valor): string
    {
        return sprintf('%02d', $id) . sprintf('%02d', strlen($valor)) . $valor;
    }

    private function calcularCRC16(string $str): string
    {
        $crc = 0xFFFF;
        $str = utf8_encode($str);
        
        for ($i = 0; $i < strlen($str); $i++) {
            $crc ^= ord($str[$i]) << 8;
            for ($j = 0; $j < 8; $j++) {
                $crc = ($crc & 0x8000) ? (($crc << 1) ^ 0x1021) : ($crc << 1);
            }
        }
        
        return strtoupper(dechex($crc & 0xFFFF));
    }

}