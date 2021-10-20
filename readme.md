<p align="center"><img src="/image/logo.png"></p>

<p align="center">
	<a href="">
		<img src="/image/demo_video.png" />
	</a>
	<a href="">
		<img src="/image/demo_button.png" />
	</a>
	<a href="">
		<img src="/image/document_button.png" />
	</a>
</p>


<p align="center">
	<a href="https://github.com/osamhack2021/WEB_IOT_ComradeMarket_MiscThings/stargazers"><img alt="GitHub stars" src="https://img.shields.io/github/stars/osamhack2021/WEB_IOT_ComradeMarket_MiscThings"></a>
	<a href="https://github.com/osamhack2021/WEB_IOT_ComradeMarket_MiscThings/blob/master/LICENSE"><img alt="GitHub forks" src="https://img.shields.io/github/forks/osamhack2021/WEB_IOT_ComradeMarket_MiscThings"></a>
	<a href="https://github.com/osamhack2021/WEB_IOT_ComradeMarket_MiscThings/blob/master/LICENSE"><img alt="GitHub license" src="https://img.shields.io/github/license/osamhack2021/WEB_IOT_ComradeMarket_MiscThings"></a>
</p>


# 프로젝트 소개

저희 **전우 장터** 프로젝트는 한 선임분의 말씀 하신 한 말에서 시작되었습니다.

**"이번에 하나 산 물건이 있는데.. 쓸 곳이 없네.."**

최근, 코로나로 인해 많은 장병들이 휴가를 나가지 못하고 부대 내에서 생활을 하고 있는 상태입니다. 그러다 보니, 자연스럽게 부대에서 지내는 시간이 늘어났고, 그만큼 부대 내에서 쓰기 위해 다양한 물건들을 택배로 받거나, 부대 내에서 구매하여 사용하고 있는 상황입니다.

위와 같은 상황에서 구매한 물건이 자신에게 잘 맞고, 잘 쓰인다면 문제가 없지만.. 그렇지 못한 경우 또한 존재합니다. 이럴 경우, 본래라면 반품이나 환불을 하거나, 중고거래를 통해 물건을 팔 수 있지만 군대에서는 이와 관련하여 마련된 공간이 없거나, 있더라도 활용 및 관리가 잘 되고 있지 않은 상황이었습니다.

또한, 중고거래를 진행한다고 가정할 때, 일근으로 근무하는 경우에는 주말에 만나서 거래를 하거나, 약속을 잡을 수가 있지만, 스케줄 근무의 경우 근무 일정이 불규칙적이기에 약속을 잡기에 어려움이 있을 것이라 생각되었으며, 꾸준히 부대 내에서도 확진자가 발생하는 사례가 발생하는 만큼, 이를 주의할 필요가 있어 보였습니다.

위와 같은 이유로, **전우 장터** 프로젝트가 시작되었습니다.

**전우장터**는 군 생활을 하는 장병 및 군무원, 간부를 대상으로 중고거래 플랫폼을 제공하고 판매 물건을 보관할 수 있는 보관함을 제공하는 웹 & IOT 프로젝트이며, 거래하시는 분들이 마음 놓고 거래할 수 있는 **안전한 플랫폼**을 제작하기 위해 노력하였습니다.

<!-- 
	<p align="center"><img src="/image/OSAM-function.png"></p>
	<p align="center"><img src="/image/OSAM-IOT.png"></p>
	<p align="center"><img src="/image/OSAM-platform.png"></p>
-->

# 기능 설명

전우장터 프로젝트는 크게 거래를 진행할 수 있는 **웹사이트**, 거래한 물건을 보관하고, 수령할 수 있는 **보관함**으로 이루어져있는 프로젝트입니다.

해당 프로젝트가 가지고 있는 기능들에 대해서 설명하기 위해, 먼저 웹사이트 및 보관함이 가지고 있는 기능들을 차례대로 소개해드린 후, 플로우 차트 및 시나리오에 따라 설명을 진행하도록 하겠습니다. 

## 웹사이트 (WEB)

전우장터의 웹사이트는 크게 유저, 상품, 문의, 운영자에 대한 기능들이 구현된 상태입니다.

해당 웹사이트를 통해, 중고 상품 거래의 대부분의 과정이 수행됩니다. 유저 등록을 통해, 사용자의 정보를 파악하여, 부대 혹은 소속 부대 근처 도시 정보를 확인한 뒤, 그에 맞는 상품을 조회할 수 있게 해주며, 상품을등록하고, 이를 구매하는 과정에서 쪽지를 이용하여, 판매자와 구매자 간 소통이 이루어집니다. 

또한 거래 도중 문제가 발생하거나, 사이트 및 서비스 상에 문제가 발생할 경우, 문의를 통해 이를 운영자에게 문의할 수 있도록 구현 되었습니다. 

### 유저 관련 기능

- 로그인, 로그아웃, 회원가입, 아이디 찾기, 비밀번호 임시 발급, 비밀번호 변경, 이메일 변경, 마이페이지 기능 제공

<table>
        <tbody>
		<tr>
			<td colspan=2>
				<br>
				<b> 유저 관련 기능 </b><br>
				<br>
			</td>
		</tr>
		<tr>
            <td rowspan="2"><div align="center"><a href="https://raw.githubusercontent.com/osamhack2021/WEB_IOT_ComradeMarket_MiscThings/master/image/user0.png"><img src="/image/user0.png" width="60%" height="60%"></a></div></td>
        </tr>
		<tr>
            <td rowspan="2"><div align="center"><a href="https://raw.githubusercontent.com/osamhack2020/WEB_KookbangFriends_Woowahan/master/image/user1.png"><img src="/image/user1.png" width="60%" height="60%"></a></div></td>
        </tr>
        <tr>
            <td rowspan="2"><div align="center"><a href="https://raw.githubusercontent.com/osamhack2020/WEB_KookbangFriends_Woowahan/master/image/user2.png"><img src="/image/user2.png" width="60%" height="60%"></a></div></td>
        </tr>
		<tr>
            <td rowspan="2"><div align="center"><a href="https://raw.githubusercontent.com/osamhack2020/WEB_KookbangFriends_Woowahan/master/image/user3.png"><img src="/image/user3.png" width="60%" height="60%"></a></div></td>
        </tr>
   </tbody>
</table>

### 상품 관련 기능 (물품 거래 관련)

- 상품 등록, 삭제, 상품 검색, 상품 조회, 상품 필터링 (부대 도시 및 소속 단위), 유저 등록 및 구매 상품 조회 기능 제공

### 문의 관련 기능

- 문의 글 작성 (비밀 / 공개), 문의 글 삭제, 문의 글 조회, 문의 글 답변 기능 제공

### 운영자 관련 기능

- 상품 삭제, 유저 삭제, 운영자 권한 부여 기능 제공

### DB 스키마

- 유저, 상품, 문의, 쪽지 기능들을 제공하기 위해 설계된 DB 스키마 정보입니다.

<p align="center"><img src="/image/DB.png"></p>

## 보관함 (IOT)

보관함 (IOT) 파트를 진행하면서, 실제 아두이노 및 키트를 부대 내에 반입하기에는 보안상의 문제가 있었기에, 대신하여 TINKERCAD를 이용하여 아두이노를 구성한 후, 테스트 코드를 작성하여 진행하였습니다.

해당 보관함의 경우, 웹 플랫폼을 통해 발급된 QR 코드를 기반으로, 보관함을 잠금/해제 할  수 있도록 제작되었습니다.

주요 기능으로는 QR 코드를 읽고, 해당 값에 따라 이를 판단할 수 있는 기능이 존재합니다.

웹사이트 거래를 통해 발급된 Qr를 이용하여, 해당 보관함을 이용할 수 있으며, 물건에 대한 QR은 물건당 1개가 발급되며, 이는 구매자 및 판매자 모두 확인할 수 있습니다. 

- 보관함 플로우 차트
<p align="center"><img src="/image/OSAM-IOT.png"></p>

- 아두이노 키트 및 실제 모의 동작 화면
<p align="center"><img src="/image/QR_Code.png"></p>
<p align="center"><img src="/image/QR_Code2.png"></p>

## 플랫폼 거래과정
<p align="center"><img src="/image/OSAM-WEB.png"></p>

전우장터의 거래과정은 위 플로우 차트 이미지와 동일합니다.

1. 중고 물품 판매를 원하는 판매자가 상품을 업로드합니다.
2. 구매자가 상품을 둘러보던 도중, 원하는 상품을 조회하고 구매 의사를 밝힙니다.
3. 구매 의사를 밝히는 경우, 판매자에게 쪽지를 보내게 됩니다.
4. 판매자는 해당 쪽지를 확인하여, 구매자와 연락을 가질 수 잇습니다.
5. 최종적으로 대화를 통해, 거래가 완료되면 구매자는 쪽지 내에서 판매 완료 버튼을 통해, 거래를 완료할 수 있습니다.
6. 거래가 완료되면, 이를 확인한 후, 상품 내 게시글 상태를 변경하여 게시글의 판매 방법에 따라 보관함을 사용하는 경우 QR 코드 발급을 진행합니다.
7. QR 코드 발급이 완료된 경우, 해당 QR의 링크를 구매자에게 전달합니다. (판매자 또한 보낸 쪽지함에서 이를 확인할 수 있습니다.)
8. 보관함을 사용하지 않는 경우 (부대 내 직거래), 별도의 QR을 발송하지 않으며 거래가 완료되었다는 내용이 담긴 쪽지를 구매자에게 전달합니다.

QR 코드를 이용하여, 판매자는 보관함에 자신이 판매한 물건을 보관할 수 있으며, 구매자 또한 해당 QR 코드를 이용하여 물건을 수령할 수 있습니다.

## 플랫폼 플로우 차트 & 기능 리스트

### 플랫폼 기능 리스트 (트리)
<p align="center"><img src="/image/OSAM-function.png"></p>

### 플랫폼 플로우 차트
<p align="center"><img src="/image/OSAM-platform.png"></p>

 
# 전우장터 기대효과
## 경제적 효과

전우장터를 통해, 군 내에서 중고거래가 진행된다면, 잘못 주문한 물건이나 자신에게 맞지 않는 물건을 필요한 분들에게 합리적인 가격으로 판매할 수 있게 되며, 특히 전역을 앞두고 기존에 생활관에서 사용하던 물건들을 판매함으로써, 물건들을 더욱 장기적으로 쓸 수 있게 되며, 중고 물건을 합리적인 가격에 구매함으로써 얻을 수 있는 경제적 효과를 기대할 수 있을 것 입니다.

## 부대 내,외 연결 & 소통 공간 조성 효과

전우장터는 단순히, 부대 내에서만 거래가 진행이 가능한 것이 아닌, 타군 및 타 부대와도 거래가 가능하도록 설계된 플랫폼입니다. 또한 쪽지 기능을 통해, 상품을 거래하면서 쪽지를 주고 받고 거래를 진행하면서 소통을 할 수 있으며, 필요에 따라 문의 게시판을 소통 공간으로도 사용할 수 있기에, 추후에는 하나의 큰 소통 공간을 조성하여 많은 분들이 대화를 나누고, 거래를 진행하는 플랫폼으로 성장할 수 있을 것입니다.

## 비대면 거래를 통한 코로나 예방

코로나로 인해, 부대 내 및 외에서도 지속적으로 감염자가 발생하고 잇습니다. 이런 상황에서 전우장터의 보관함 서비스를 통해, 중고거래를 진행하더라도 서로 접촉하지 않고도 비대면으로 거래를 진행할 수 있기에, 코로나 예방 관점에서 많은 도움을 줄 수 있을 것입니다.


# 전우장터 경쟁력

## 안전한 중고거래

이전에 존재하던 중고거래 플랫폼의 경우, 악의적인 사용자 및 사기로 인해 많은 어려움을 겪었습니다. 그런 만큼, 보다 더 안전한 중고거래 플랫폼을 만들고, 악의적인 사용자 및 사기에 대해서 대응하기 위해, 문의 게시판 및 운영자 기능들을 제공하고 있으며, 추후 추가적으로 결재 기능을 도입하여, 안전 결제 및 페이 연동을 통해 안전한 거래를 진행할 수 있도록 하고자 합니다.

## 안전한 플랫폼 구성

이번 전우장터를 구현하면서, 정보호호병으로 구성된 팀인 만큼, 더욱 안전한 플랫폼을 구성하고자 노력하였습니다. 그 결과, SQL Injection 및 XSS 공격에 대응하여 이를 방지할 수있는 함수들을 통해, 보안을 강화하였으며, 패스워드와 같은 정보를 암호화함으로써, 패스워드가 유출된다고 하더라도, 본래 패스워드 값을 확인할 수 없도록 조치하였습니다.

## 개발문서 & 설계의 구체성

전우장터를 구현하는 과정에서, 이를 체계적으로 진행하기 위해 다양한 문서 작업 및 설계과정을 거쳤습니다. 먼저 구현을 진행하기 전에, 필요한 기능들을 트리 형태로 작성하고, 개발 일정을 WBS를 통해 작성한 뒤, 이를 간트차트로 제작하였습니다. 또한, 프론트엔드 구현을 진행하기 전, 목업을 작성하여 필요한 부분들을 알아보고, 설계하였으며 웹사이트 및 IOT 동작과 관련된 플로우 차트를 제작하였습니다.

## 보관함 및 플랫폼의 활용 가능성

해당 플랫폼의 경우, 현재로써는 중고거래 서비스만 제공하고 있는 상태이지만, QR 발급 기능 및 보관함 기능을 활용하여, 중고거래만이 아닌, 보관함 기능을 추가적으로 제공할 수 있습니다. 별개로 웹 플랫폼의 쪽지 기능, 문의 기능들을 이용하여, 중고거래 플랫폼만이 아닌, 하나의 소통 공간으로 발전할 수 있는 가능성을 가지고 있으며 이를 다양한 용도로 활용할 수 있을 것이며, 도커 형태로 바로 서비스를 진행할 수 있기에 많은 도움이 될 것이라 예상됩니다. 

## 팀 소개 & 개발자 소개
- 전우장터
- 이창엽 (lcy606@naver.com), Github Id: YeoPEVA
- 이진우 (solrukas@kakao.com), Github Id: solrukas

## 팀 정보 (Team Information)
<table width="788">
	<thead>
		<tr>
			<th width="100" align="center">사진</th>
			<th width="100" align="center">성명</th>
			<th width="150" align="left">담당</th>
			<th width="100" align="center">깃허브</th>
			<th width="175" align="center">이메일</th>
		</tr> 
	</thead>
	<tbody>
		<tr>
			<td width="100" align="center"><img src="/image/PROFILE1.jpg" width="60" height="60"></td>
			<td width="100" align="center">이창엽</td>
			<td width="150">프론트엔드 개발<br>백엔드 개발<br>문서화 작업 등</td>
			<td width="100" align="center">
				<a href="https://github.com/YeoPEVA">
					<img src="http://img.shields.io/badge/YeoPEVA-655ced?style=social&logo=github"/>
				</a>
			</td>
			<td width="175" align="center">
				<a href="mailto:lcy496530@gmail.com"><img src="https://img.shields.io/static/v1?label=&message=lcy496530@gmail.com&color=orange&style=flat-square&logo=gmail"></a>
			</td>
		</tr>
		<tr>
			<td width="100" align="center"><img src="/image/PROFILE2.jpg" width="60" height="60"></td>
			<td width="100" align="center">이진우</td>
			<td width="300">백엔드 개발<br>IOT 개발<br>영상 작업 등</td>
			<td width="100" align="center">
				<a href="https://github.com/Solrukas">
					<img src="http://img.shields.io/badge/Solrukas-655ced?style=social&logo=github"/>
				</a>
			</td>
			<td width="175" align="center">
				<a href="mailto:solrukas@gmail.com"><img src="https://img.shields.io/static/v1?label=&message=solrukas@gmail.com&color=green&style=flat-square&logo=gmail"></a>
				</td>
		</tr>
</tr>
</tbody>
</table>


## 컴퓨터 구성 / 필수 조건 안내 (Prerequisites)
* ECMAScript 6 지원 브라우저 사용
* 권장: Google Chrome 버젼 77 이상
* 주의 : Internet Explorer 8.0 이하 버전 (일부 기능 지원 불가)

## 기술 스택 (Technique Used)
<p align="center"><img src="/image/platform.png"></p>

### Front-end
 -  HTML & CSS, Javascript 
 -  UI framework

### Server(back-end)
 - Apache2, PHP, Mysql, Docker 


## 서비스 이용방법 (For User)
- WEB
[http://osam.kro.kr/](http://osam.kro.kr/) 웹사이트 접속 후 서비스 이용 가능.

- IOT
발급된 QR을 이용하여, 보관함 서비스 사용 가능.

## 프로젝트 사용법 (Getting Started)
** 진행 중.. **

```bash
$ git clone git주소
$ yarn or npm install
$ yarn start or npm run start
```
## 저작권 및 사용권 정보 (Copyleft / End User License)
 * [MIT](https://github.com/osam2020-WEB/Sample-ProjectName-TeamName/blob/master/license.md)

This project is licensed under the terms of the MIT license.
