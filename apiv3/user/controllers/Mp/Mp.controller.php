<?php

require_once MODELS . '/Mp/order.php';

class MpController extends MpPayment {

    public function __construct() {
        $this->model = New MpPayment();
    }

    //ORDER APPLE
    public function orderApple() {
      $this->model->orderApple($this->model);
    }
    public function createTokenCard() {
      $this->model->createTokenCard($this->model);
    }
    public function orderCartao() {
      $this->model->orderCartao($this->model);
    }
    public function orderCartaoCoin() {
      $this->model->orderCartaoCoin($this->model);
    }
    public function orderBoleto() {
      $this->model->orderBoleto($this->model);
    }
    public function orderBoletoCoin() {
      $this->model->orderBoletoCoin($this->model);
    }
    public function orderPix() {
      $this->model->orderPix($this->model);
    }
    public function orderPixCoin() {
      $this->model->orderPixCoin($this->model);
    }
    public function notificacao() {
      $this->model->notificacao($this->model);
    }
    public function notificacaoCoin() {
      $this->model->notificacaoCoin($this->model);
    }
    public function listAll() {
      $this->model->listAll($this->model);
    }
    public function comprarAvulso() {
      $this->model->comprarAvulso($this->model);
    }

}
