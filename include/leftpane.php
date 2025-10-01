<div id="leftpane">
    <?php
    if (empty($_SESSION["setid"])):
    ?>
        <p><a href="<?= $esurl ?>member_regist01"><img src="<?= $imgurl ?>img/common/regist_menu.gif" width="200" height="122" alt="【太陽と野菜の直売所】（東浪見岡本農園）の会員募集中です！（事前登録）"></a></p>
    <?php
    endif;
    ?>
    <dl class="menu1">
        <dt>野菜狩り・レンタル農園サービス</dt>
        <dd>
            <ul>
                <li><a href="<?= $esurl ?>yoyakuform01">野菜狩り・野菜収穫体験サービスを始めました！</a></li>
                <?php
                if (1 == 2):
                ?>
                    <li><a href="<?= $esurl ?>subscription">有機野菜販売のサブスクリプション契約を開始しました！</a></li>
                <?
                endif;
                ?>
                <li><a href="<?= $esurl ?>rental_newfarmer">新規就農者個人事業向け レンタル農園・貸し農園</a></li>
                <li><a href="<?= $esurl ?>rental_farm">レンタル農園・貸し農園（6坪）</a></li>
                <li><a href="<?= $esurl ?>rental_farm_option">レンタル農園 オプション料金表</a></li>
                <li><a href="<?= $esurl ?>rental_farm_company">福利厚生用途の期間貸しレンタル農園サービス</a></li>
                <li><a href="<?= $esurl ?>kitchen_rental">レンタル厨房・レンタルキッチンのご案内</a></li>
                <li><a href="<?= $esurl ?>restaurant">観光農園敷地内で飲食店を始めてみませんか？</a></li>
                <li><a href="<?= $esurl ?>cooking_idea">料理大好きな方「名案」を大募集しています！</a></li>
                <li><a href="<?= $esurl ?>ordermade">オーダーメイド野菜の少量栽培に対応しています</a></li>
                <li><a href="<?= $esurl ?>volunteer">農業ボランティア・農作業体験をしたい方大募集です！</a></li>

            </ul>
        </dd>

    </dl>


    <dl class="menu3">
        <dt>農地耕運代行・農地復活代行</dt>
        <dd>
            <ul>

                <li><a href="<?= $esurl ?>rental">農機・農機具・耕運機のレンタルサービス始めました</a></li>
                <li><a href="<?= $esurl ?>product_list">農機・農機具・耕運機レンタル重機　一覧</a></li>
                <?php
                if (1 == 2):
                ?>
                    <li><a href="<?= $esurl ?>rental_price">農機・農機具・耕運機レンタル　料金表</a></li>
                <?
                endif;
                ?>
                <li><a href="<?= $esurl ?>agency_service">農地耕運代行・農地復活代行サービス</a></li>
                <li><a href="<?= $esurl ?>consulting">農地取得相談・農地選定コンサルティングサービス</a></li>
                <li><a href="<?= $esurl ?>farming_support">農業指導・家庭菜園野菜作りサポート</a></li>
                <li><a href="<?= $esurl ?>purchase_service">中古農機具、使わなくなったトラクター買取りいたします！</a></li>
                <li><a href="<?= $esurl ?>grasspicking">草刈り代行サービスを始めました！</a></li>
                <li><a href="<?= $esurl ?>herbicides_service">除草剤散布サービス</a></li>
            </ul>
        </dd>

    </dl>

    <dl class="menu5">
        <dt>誰でもできる有事のときの食料安全保障</dt>
        <dd>
            <ul>

                <li><a href="<?= $esurl ?>ensure_service">野菜栽培のための農地利用権利の確保サービスのご案内</a></li>
                <li><a href="<?= $esurl ?>security">家庭で準備すべき有事の際の食料安全保障</a></li>
            </ul>
        </dd>

    </dl>

    <dl class="menu4">
        <dt>おしゃれな農業と言われるまで</dt>
        <dd>
            <ul>

                <li><a href="<?= $esurl ?>fashionable">農業が「おしゃれ」である理由</a></li>
                <li><a href="<?= $esurl ?>energy">農業から得る「正の気のエネルギー」とおしゃれな心</a></li>
                <li><a href="<?= $esurl ?>living">本気で「清貧暮らし」を目指すなら農業が最適です！</a></li>
            </ul>
        </dd>

    </dl>

    <dl class="menu6">
        <dt>農業ロボット開発に対する農地の提供サービス</dt>
        <dd>
            <ul>

                <li><a href="<?= $esurl ?>farm_robots">農業ロボットの実験検証設備としてお考えの方</a></li>
            </ul>
        </dd>

    </dl>

    <dl class="menu8">
        <dt>農園で「癒し」を得てみませんか？</dt>
        <dd>
            <ul>

                <li><a href="<?= $esurl ?>aguri_healing">アグリ（農業）ヒーリング体験</a></li>
                <li><a href="<?= $esurl ?>lazy">「横着癖」が農業を通じて治せることを知っていますか？</a></li>
                <li><a href="<?= $esurl ?>polite">農業に携わると「丁寧な心」が身につくことをご存じですか？</a></li>
                <li><a href="<?= $esurl ?>lifeconsul_service">農園で「人生相談・恋愛相談」してみませんか？</a></li>
            </ul>
        </dd>

    </dl>


    <!--id leftpane end-->
</div>