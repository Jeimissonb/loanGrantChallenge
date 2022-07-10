<?php include 'includes/head.php'; ?>

<main class="page" id="emprestimo">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <form method="POST" action="{{ route('SimulationController.SendCalculate') }}" class="form">

                        <div class="box-title">
                            <h1 class="title">Valor pretendido em R$:</h1>
                            @csrf
                            <div class="numbers">
                                <div class="box-number orange">
                                    <input type="text" name="pretended_value" value="{{ old('pretended_value') }}"
                                        class="number" id="valor-pretendido" data-mask="money" required>
                                </div>


                                <div class="box-number orange-border">
                                    <span class="desc">Valor Minímo</span>
                                    <span class="number">R$ 5 mil</span>
                                </div>
                            </div>
                            <button type="submit" formaction="{{ route('SimulationController.Calculate') }}"
                                class="btn btn-green">Calcular</button>
                        </div>

                        <div class="prazo-meses">
                            <div class="box-title">
                                <h2 class="title">Selecione o prazo desejado:</h2>
                            </div>
                            <div class="box-text">
                                <h2 class="title-page">
                                    <img src="/assets/images/calendar.svg" alt="">
                                    Prazo em meses
                                </h2>

                                <p class="item limite-valor d-none">Limite de crédito:</p>
                                <p class="item item-mb limite-valor d-none">Valor da parcela:</p>
                                <p class="item">Custo efetivo ao mês:</p>
                            </div>

                            <div class="prazos">
                                <div class="box-select">
                                    <input type="radio" name="pretended_deadline" id="6-meses" value="6">
                                    <label class="content" for="6-meses">
                                        <div class="mes">
                                            <span class="num">6</span>/Meses
                                        </div>

                                        <div class="number white limite-valor d-none">
                                            <span class="desc">Limite de crédito:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden-white.svg"
                                                        alt=""> <span>***</span></div> <span class="total">R$
                                                    1000,00</span>
                                            </span>
                                        </div>

                                        <div class="number limite-valor d-none">
                                            <span class="desc">Valor da parcela:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden.svg" alt="">
                                                    <span>***</span>
                                                </div> <span class="total">6x de: <br>R$ <span
                                                        id="parcela6">2.685,00</span></span>
                                            </span>
                                        </div>

                                        <div class="number orange">
                                            <span class="desc">Custo efetivo ao mês:</span>
                                            <span class="value">17,9%</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="box-select">
                                    <input type="radio" name="pretended_deadline" id="12-meses" value="12">
                                    <label class="content" for="12-meses">
                                        <div class="mes">
                                            <span class="num">12</span>/Meses
                                        </div>

                                        <div class="number white limite-valor d-none">
                                            <span class="desc">Limite de crédito:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden-white.svg"
                                                        alt=""> <span>***</span></div> <span class="total">R$
                                                    1000,00</span>
                                            </span>
                                        </div>

                                        <div class="number limite-valor d-none">
                                            <span class="desc">Valor da parcela:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden.svg" alt="">
                                                    <span>***</span>
                                                </div> <span class="total">12x de: <br><span
                                                        id="parcela12">1.410,00</span></span>
                                            </span>
                                        </div>

                                        <div class="number orange">
                                            <span class="desc">Custo efetivo ao mês:</span>
                                            <span class="value">9,4%</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="box-select">
                                    <input type="radio" name="pretended_deadline" id="24-meses" value="24">
                                    <label class="content" for="24-meses">
                                        <div class="mes">
                                            <span class="num">24</span>/Meses
                                        </div>

                                        <div class="number white limite-valor d-none">
                                            <span class="desc">Limite de crédito:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden-white.svg"
                                                        alt=""> <span>***</span></div> <span class="total">R$
                                                    1000,00</span>
                                            </span>
                                        </div>

                                        <div class="number limite-valor d-none">
                                            <span class="desc">Valor da parcela:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden.svg"
                                                        alt="">
                                                    <span>***</span>
                                                </div> <span class="total">24x de: <br><span
                                                        id="parcela24">780,00</span></span>
                                            </span>
                                        </div>

                                        <div class="number orange">
                                            <span class="desc">Custo efetivo ao mês:</span>
                                            <span class="value">5.2%</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="box-select">
                                    <input type="radio" name="pretended_deadline" id="36-meses" value="36">
                                    <label class="content" for="36-meses">
                                        <div class="mes">
                                            <span class="num">36</span>/Meses
                                        </div>

                                        <div class="number white limite-valor d-none">
                                            <span class="desc">Limite de crédito:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden-white.svg"
                                                        alt=""> <span>***</span></div> <span class="total">R$
                                                    1000,00</span>
                                            </span>
                                        </div>

                                        <div class="number limite-valor d-none">
                                            <span class="desc">Valor da parcela:</span>
                                            <span class="value">
                                                <div class="icon"><img src="/assets/images/hidden.svg"
                                                        alt="">
                                                    <span>***</span>
                                                </div> <span class="total">36x de: <br><span
                                                        id="parcela36">555,00</span></span>
                                            </span>
                                        </div>

                                        <div class="number orange">
                                            <span class="desc">Custo efetivo ao mês:</span>
                                            <span class="value">3.7%</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="prazo-estendido">
                            <div class="box-desc">
                                <h2 class="title-page">
                                    <img src="/assets/images/calendar.svg" alt="">
                                    Prazo pretendido
                                </h2>

                                <div class="mes">
                                    <span class="num">6</span>/Meses
                                </div>

                                <div class="valor">
                                    <div class="box-num green">
                                        <span class="number">R$ 18.208,72</span>
                                    </div>
                                    <div class="box-calc">
                                        <span class="number">
                                            12x de: R$ 2.685,00
                                        </span>
                                    </div>
                                    <div class="box-num orange">
                                        <span class="number" id="porcentagemPretendida">17,9%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="box-interesse">
                                <img src="/assets/images/interesse.svg" alt="" class="icon">

                                <h2 class="title-page">Confirme aqui seu interesse</h2>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input onChange="this.form.submit()" type="radio" class="custom-control-input"
                                        name="saved" id="sim" value="sim">
                                    <label class="custom-control-label" for="sim">Sim, estou interessado</label>
                                </div>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="saved"
                                        id="nao" value="nao">
                                    <label class="custom-control-label" for="nao">Não tenho interesse</label>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="custo-efetivo">
                        <h2 class="title-page">Composição do custo efetivo</h2>

                        <table class="no-border">
                            <tr>
                                <td>Taxa de juros:</td>
                                <td><span class="orange">1,2%</span> ao mês</td>
                            </tr>
                            <tr>
                                <td>Taxa de administração:</td>
                                <td><span class="orange">2,5%</span> na concessão + <span class="orange">0,1%</span>
                                    ao mês sobre o saldo devedor</td>
                            </tr>
                            <tr>
                                <td>Taxa de juros:</td>
                                <td><span class="orange">0,38%</span> na concessão + <span
                                        class="orange">0,0082%</span> ao dia sobre o saldo devedor (limitado a 365
                                    dias)</td>
                            </tr>
                        </table>
                    </div>

                    <div class="condicoes">
                        <p class="text-page">As <strong>condições finais</strong> serão informadas no momento da
                            assinatura do contrato. <br>
                            O programa de empréstimos será implantado somente caso haja interesse de pelo menos 200
                            participantes, que solicitem crédito total de no mínimo R$ 5 milhões.</p>
                    </div>


                    <button type="button" class="btn btn-green"><a href="/logout" title="Ir para página inicial"
                            class="btn btn-green">Sair</a></button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
