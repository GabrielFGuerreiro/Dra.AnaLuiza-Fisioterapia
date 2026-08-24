<div class="preconsulta-page">
    <section class="preconsulta-card">
        <div class="preconsulta-heading">
            <span class="section-kicker">Agende seu Atendimento</span>
            <h1>Pré-consulta</h1>
            <p>Informe a Data e o Horário Desejados.<br>A Confirmação será Feita pela Doutora.</p>
        </div>

        <div id="msgAlerta" class="alerta-form form-alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span></span>
        </div>

        <form action="<?= BASE_URL ?>/cadastrarConsulta" method="POST" class="preconsulta-form form-layout" id="formCadastrarConsulta">
            <div class="preconsulta-field">
                <label for="dtPreferencia">Data de preferência</label>
                <input type="date" id="dtPreferencia" name="dtPreferencia">
            </div>
            <div class="preconsulta-field">
                <label for="horarioInicial">Horário de preferência</label>
                <input type="time" id="horarioInicial" name="horarioInicial">
                <small>A consulta terá duração prevista de uma hora.</small>
            </div>
            <div class="preconsulta-field">
                <label for="observacao">Observação <span>(opcional)</span></label>
                <textarea id="observacao" name="observacao" rows="4" maxlength="450" placeholder="Escreva alguma informação importante para a Doutora." style="resize:none"></textarea>
            </div>
            <button type="submit" class="preconsulta-submit"><i class="fa-regular fa-calendar-check"></i>Enviar Consulta</button>
        </form>
    </section>
</div>

<?php require "footer.php"; ?>


<script>

    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        const msg = params.get("msg");
        const sucesso = params.get("sucesso");
        if (msg)
        {
            Swal.fire({
                title: msg,
                icon: sucesso === "1" ? "success" : "error",
                confirmButtonText: 'Ok'
            });

            // O resultado já foi exibido; remove os dados do POST da URL.
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });


    document.getElementById("formCadastrarConsulta").addEventListener("submit", function(e)
    {
        e.preventDefault();
        const dataConsulta = document.getElementById("dtPreferencia");

        const hoje = new Date();
        const ano = hoje.getFullYear();
        const mes = String(hoje.getMonth() + 1).padStart(2, "0");
        const dia = String(hoje.getDate()).padStart(2, "0");

        if(!dataConsulta.value)
        {
            mostrarAlerta("Informe o dia da consulta.");
            return;
        }

        if(dataConsulta.value < `${ano}-${mes}-${dia}`)
        {
            mostrarAlerta("A data da consulta não pode ser anterior à data atual.");
            return;
        }

        if(!document.getElementById("horarioInicial").value)
        {
            mostrarAlerta("Informe o horário da consulta.");
            return;
        }

        this.submit();
    });
</script>