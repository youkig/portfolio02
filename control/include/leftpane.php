<div id="leftpane">
  <dl class="categorymenu">
    <?php
    if (1 == 2) {
    ?>
      <dt id="menu_1" class="first-child">基本情報</dt>
      <dd id="submenu_1">
        <ul>
          <li><a href="memberdisp.php?kanri=1">管理者設定</a></li>

          <li><a href="mailconf.php">発送メール内容編集</a></li>
        </ul>
      </dd>
    <?php
    }
    ?>
    <dt id="menu_2">HP管理</dt>
    <dd id="submenu_2">
      <ul>
        <li><a href="news.php">お知らせ編集</a></li>
        <li><a href="bisiness_hours.php">営業時間設定</a></li>
        <?php
        if (1 == 2) {
        ?>
          <li><a href="calendar.php">カレンダー設定</a></li>
          <li><a href="faq.php">FAQ編集</a></li>
        <?php
        }
        ?>
      </ul>
    </dd>

    <dt id="menu_14">メールマガジン管理</dt>
    <dd id="submenu_14">
      <ul>
        <li><a href="mailmagasend.php">メールマガジン送信設定</a></li>
        <li><a href="mailmaga_history.php">過去のメールマガジン一覧</a></li>
        <li><a href="mailmagastop.php">メールマガジン緊急停止</a></li>
      </ul>
    </dd>

    <dt id="menu_15">FAQ管理</dt>
    <dd id="submenu_15">
      <ul>
        <li><a href="faqcate.php">FAQカテゴリの登録・編集</a></li>
        <li><a href="faq.php">FAQ登録・一覧</a></li>
      </ul>
    </dd>

    <dt id="menu_11">レンタル重機管理</dt>
    <dd id="submenu_11">
      <ul>
        <li><a href="category_02.php?b1id=1">カテゴリ編集・登録</a></li>
        <li><a href="productlist.php">レンタル重機一覧</a></li>
        <li><a href="regist.php">新規レンタル重機登録</a></li>
        <?php
        if (1 == 2) {
        ?>
          <li><a href="productreservelist.php">予約一覧</a></li>
          <li><a href="productreservedisp.php">新規予約登録</a></li>
        <?php
        }
        ?>
      </ul>
    </dd>

    <dt id="menu_3">写真集</dt>
    <dd id="submenu_3">
      <ul>
        <li><a href="mailmagaphotoupload.php">写真アップロード</a></li>
        <li><a href="mailmagaImagelist.php">写真一覧</a></li>
      </ul>
    </dd>

    <dt id="menu_4">今週末野菜狩りのできる野菜</dt>
    <dd id="submenu_4">
      <ul>
        <?php
        if (1 == 2) {
        ?>
          <li><a href="maker.php">メーカー設定</a></li>
          <li><a href="optionset.php">オプション設定</a></li>
        <?php
        }
        ?>
        <li><a href="disp.php">新規野菜登録</a></li>
        <li><a href="list.php">今週末野菜狩りのできる野菜一覧</a></li>
      </ul>
    </dd>

    <dt id="menu_12">野菜狩り予約管理</dt>
    <dd id="submenu_12">
      <ul>
        <li><a href="yasaigarimemberlist.php">野菜狩り予約一覧</a></li>
        <?php
        if (1 == 2) {
        ?>
          <li><a href="subsclist.php">野菜狩りサブスクリプション一覧</a></li>
        <?php
        }
        ?>
        <li><a href="yasaigarinews.php">野菜狩りコメント設定</a></li>
        <li><a href="yasaigarimemberdisp.php">野菜狩り新規予約登録</a></li>
        <li><a href="yasaigarieigyo.php">臨時営業日設定</a></li>
        <li><a href="yasaigaririnji.php">臨時休業日設定</a></li>
      </ul>
    </dd>

    <dt id="menu_13">苦情、ご意見投稿管理</dt>
    <dd id="submenu_13">
      <ul>
        <li><a href="bbslist.php">苦情、ご意見投稿一覧</a></li>

      </ul>
    </dd>

    <dt id="menu_5">予約管理</dt>
    <dd id="submenu_5">
      <ul>
        <li><a href="reservedlist.php">予約一覧</a></li>
      </ul>
    </dd>

    <dt id="menu_8">一般会員管理</dt>
    <dd id="submenu_8">
      <ul>
        <li><a href="userlist.php">一般会員一覧</a></li>
      </ul>
    </dd>

    <dt id="menu_10">疎開先ネットワーク会員管理</dt>
    <dd id="submenu_10">
      <ul>
        <li><a href="network_userlist.php">疎開先ネットワーク会員一覧</a></li>
        <li><a href="network_inqlist.php">疎開先ネットワーク問合せ一覧</a></li>
      </ul>
    </dd>


    <dt id="menu_11">散文詩登録・編集</dt>
    <dd id="submenu_11">
      <ul>
        <li><a href="prose.php">散文詩登録</a></li>
      </ul>
    </dd>

    <?php
    if (1 == 2) {
    ?>
      <dt id="menu_6">顧客管理</dt>
      <dd id="submenu_6">
        <ul>
          <li><a href="memberlist.php">会員一覧</a></li>
          <li><a href="memberdisp.php">新規会員登録</a></li>
        </ul>
      </dd>
    <?php
    }
    ?>

    <dt id="menu_7">帳票管理</dt>
    <dd id="submenu_7">
      <ul>
        <li><a href="receipts_list.php?t=0">領収書履歴一覧</a></li>
        <li>
          <a href="print_sheet01.php?t=0" target="_blank">新規領収書登録</a>
        </li>
        <li><a href="receipts_list.php?t=1">請求書履歴一覧</a></li>
        <li>
          <a href="print_sheet01.php?t=1" target="_blank">新規請求書登録</a>
        </li>
        <li><a href="receipts_list.php?t=2">納品書履歴一覧</a></li>
        <li>
          <a href="print_sheet01.php?t=2" target="_blank">新規納品書登録</a>
        </li>
        <li><a href="receipts_list.php?t=3">見積書履歴一覧</a></li>
        <li>
          <a href="print_sheet01.php?t=3" target="_blank">新規見積書登録</a>
        </li>
      </ul>
    </dd>

    <dt id="menu_9">契約書面</dt>
    <dd id="submenu_9">
      <ul>
        <li>
          <a href="../contract.php" target="_blank">農地利用権利の確保サービス契約書</a>
        </li>
      </ul>
    </dd>
  </dl>
</div>