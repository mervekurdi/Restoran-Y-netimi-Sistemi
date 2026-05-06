const STORAGE_KEY = 'restoran_gold_state_v6';
const BC = new BroadcastChannel('restaurant_gold');

const defaultCategories = ['Burger', 'Pizza', 'Döner & Kebap', 'Makarna', 'Sıcak İçecekler', 'Soğuk İçecekler', 'Tatlılar'];

// Using loremflickr with specific keywords to guarantee 100% image availability without 404 errors.
const defaultProducts = [
  // BURGER (7)
  {id:1, category:'Burger', name:'Klasik Burger', price:180, img:'https://image.pollinations.ai/prompt/delicious%20Klasik%20Burger%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=1', desc:'150g dana köfte, taze yeşillik ve özel burger sosu.'},
  {id:2, category:'Burger', name:'Cheeseburger', price:200, img:'https://image.pollinations.ai/prompt/delicious%20Cheeseburger%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=2', desc:'Erimiş çedar peyniri ve karamelize soğan.'},
  {id:3, category:'Burger', name:'Double Burger', price:280, img:'https://image.pollinations.ai/prompt/delicious%20Double%20Burger%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=3', desc:'İki katlı dana köfte, ekstra peynir.'},
  {id:4, category:'Burger', name:'Tavuk Burger', price:160, img:'https://image.pollinations.ai/prompt/delicious%20Tavuk%20Burger%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=4', desc:'Çıtır kaplamalı tavuk fileto.'},
  {id:5, category:'Burger', name:'BBQ Burger', price:220, img:'https://image.pollinations.ai/prompt/delicious%20BBQ%20Burger%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=5', desc:'Barbekü soslu, çıtır soğan halkalı.'},
  {id:6, category:'Burger', name:'Vejetaryen Burger', price:170, img:'https://image.pollinations.ai/prompt/delicious%20Vejetaryen%20Burger%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=6', desc:'Özel sebze köftesi ve taze yeşillikler.'},
  {id:7, category:'Burger', name:'Mantarlı Swiss Burger', price:230, img:'https://image.pollinations.ai/prompt/delicious%20Mantarl%C4%B1%20Swiss%20Burger%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=7', desc:'Sote mantar ve erimiş İsviçre peyniri.'},

  // PIZZA (7)
  {id:8, category:'Pizza', name:'Margherita', price:200, img:'https://image.pollinations.ai/prompt/delicious%20Margherita%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=8', desc:'İnce hamur, taze fesleğen ve mozzarella.'},
  {id:9, category:'Pizza', name:'Pepperoni', price:240, img:'https://image.pollinations.ai/prompt/delicious%20Pepperoni%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=9', desc:'Bol dana pepperoni ve mozzarella.'},
  {id:10, category:'Pizza', name:'Dört Peynirli', price:260, img:'https://image.pollinations.ai/prompt/delicious%20D%C3%B6rt%20Peynirli%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=10', desc:'Gorgonzola, parmesan, emmental ve mozzarella.'},
  {id:11, category:'Pizza', name:'Vejetaryen Pizza', price:210, img:'https://image.pollinations.ai/prompt/delicious%20Vejetaryen%20Pizza%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=11', desc:'Mevsim sebzeleri ve taze domates sosu.'},
  {id:12, category:'Pizza', name:'Karışık Pizza', price:280, img:'https://image.pollinations.ai/prompt/delicious%20Kar%C4%B1%C5%9F%C4%B1k%20Pizza%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=12', desc:'Sucuk, sosis, zeytin, mantar ve biber.'},
  {id:13, category:'Pizza', name:'Mantarlı Pizza', price:220, img:'https://image.pollinations.ai/prompt/delicious%20Mantarl%C4%B1%20Pizza%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=13', desc:'Bol taze mantar.'},
  {id:14, category:'Pizza', name:'Sucuklu Pizza', price:250, img:'https://image.pollinations.ai/prompt/delicious%20Sucuklu%20Pizza%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=14', desc:'Dilimli fermente sucuk ve kaşar.'},

  // DÖNER & KEBAP (7)
  {id:15, category:'Döner & Kebap', name:'Et Dürüm', price:180, img:'https://image.pollinations.ai/prompt/delicious%20Et%20D%C3%BCr%C3%BCm%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=15', desc:'Sıcak lavaş arası yaprak et döner.'},
  {id:16, category:'Döner & Kebap', name:'İskender Kebap', price:280, img:'https://image.pollinations.ai/prompt/delicious%20%C4%B0skender%20Kebap%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=16', desc:'Tereyağlı, yoğurtlu ve domates soslu.'},
  {id:17, category:'Döner & Kebap', name:'Adana Kebap', price:250, img:'https://image.pollinations.ai/prompt/delicious%20Adana%20Kebap%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=17', desc:'Zırh kıymasıyla hazırlanan acılı kebap.'},
  {id:18, category:'Döner & Kebap', name:'Tavuk Şiş', price:200, img:'https://image.pollinations.ai/prompt/delicious%20Tavuk%20%C5%9Ei%C5%9F%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=18', desc:'Özel marineli mangalda tavuk şiş.'},
  {id:19, category:'Döner & Kebap', name:'Urfa Kebap', price:250, img:'https://image.pollinations.ai/prompt/delicious%20Urfa%20Kebap%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=19', desc:'Acısız, sade kıyma kebabı.'},
  {id:20, category:'Döner & Kebap', name:'Porsiyon Döner', price:260, img:'https://image.pollinations.ai/prompt/delicious%20Porsiyon%20D%C3%B6ner%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=20', desc:'Pilav üstü odun ateşi döneri.'},
  {id:21, category:'Döner & Kebap', name:'Beyti Kebap', price:300, img:'https://image.pollinations.ai/prompt/delicious%20Beyti%20Kebap%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=21', desc:'Lavaşa sarılı, sarımsaklı yoğurtlu spesiyal.'},

  // MAKARNA (7)
  {id:22, category:'Makarna', name:'Spaghetti Bolognese', price:170, img:'https://image.pollinations.ai/prompt/delicious%20Spaghetti%20Bolognese%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=22', desc:'Kıymalı domates ragù soslu spagetti.'},
  {id:23, category:'Makarna', name:'Fettuccine Alfredo', price:190, img:'https://image.pollinations.ai/prompt/delicious%20Fettuccine%20Alfredo%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=23', desc:'Tavuklu ve kremsi parmesan soslu.'},
  {id:24, category:'Makarna', name:'Penne Arrabbiata', price:160, img:'https://image.pollinations.ai/prompt/delicious%20Penne%20Arrabbiata%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=24', desc:'Acılı domates soslu kalem makarna.'},
  {id:25, category:'Makarna', name:'Pesto Soslu', price:180, img:'https://image.pollinations.ai/prompt/delicious%20Pesto%20Soslu%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=25', desc:'Taze fesleğen, çam fıstığı ve parmesan.'},
  {id:26, category:'Makarna', name:'Ev Yapımı Mantı', price:200, img:'https://image.pollinations.ai/prompt/delicious%20Ev%20Yap%C4%B1m%C4%B1%20Mant%C4%B1%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=26', desc:'Sarımsaklı yoğurt ve nane soslu.'},
  {id:27, category:'Makarna', name:'Lazanya', price:220, img:'https://image.pollinations.ai/prompt/delicious%20Lazanya%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=27', desc:'Kat kat hamur, bol kıyma ve beşamel sos.'},
  {id:28, category:'Makarna', name:'Deniz Mahsüllü', price:260, img:'https://image.pollinations.ai/prompt/delicious%20Deniz%20Mahs%C3%BCll%C3%BC%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=28', desc:'Karides, midye ve taze domates sos.'},

  // SICAK İÇECEKLER (7)
  {id:29, category:'Sıcak İçecekler', name:'Türk Çayı', price:20, img:'https://image.pollinations.ai/prompt/delicious%20T%C3%BCrk%20%C3%87ay%C4%B1%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=29', desc:'İnce belli bardakta taze demlenmiş.'},
  {id:30, category:'Sıcak İçecekler', name:'Türk Kahvesi', price:50, img:'https://image.pollinations.ai/prompt/delicious%20T%C3%BCrk%20Kahvesi%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=30', desc:'Bol köpüklü, lokum ile servis edilir.'},
  {id:31, category:'Sıcak İçecekler', name:'Filtre Kahve', price:60, img:'https://image.pollinations.ai/prompt/delicious%20Filtre%20Kahve%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=31', desc:'%100 Arabica çekirdeklerinden.'},
  {id:32, category:'Sıcak İçecekler', name:'Caffè Latte', price:75, img:'https://image.pollinations.ai/prompt/delicious%20Caff%C3%A8%20Latte%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=32', desc:'Yumuşak içimli sıcak espresso ve süt.'},
  {id:33, category:'Sıcak İçecekler', name:'Sıcak Çikolata', price:80, img:'https://image.pollinations.ai/prompt/delicious%20S%C4%B1cak%20%C3%87ikolata%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=33', desc:'Yoğun çikolata ve krema.'},
  {id:34, category:'Sıcak İçecekler', name:'Bitki Çayı', price:40, img:'https://image.pollinations.ai/prompt/delicious%20Bitki%20%C3%87ay%C4%B1%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=34', desc:'Taze yapraklardan demlenmiş.'},
  {id:35, category:'Sıcak İçecekler', name:'Espresso', price:45, img:'https://image.pollinations.ai/prompt/delicious%20Espresso%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=35', desc:'Tek shot yoğun espresso.'},

  // SOĞUK İÇECEKLER (7)
  {id:36, category:'Soğuk İçecekler', name:'Buzlu Limonata', price:60, img:'https://image.pollinations.ai/prompt/delicious%20Buzlu%20Limonata%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=36', desc:'Taze naneli serinletici ev yapımı.'},
  {id:37, category:'Soğuk İçecekler', name:'Kutu Kola', price:40, img:'https://image.pollinations.ai/prompt/delicious%20Kutu%20Kola%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=37', desc:'Buz gibi soğuk klasik içecek.'},
  {id:38, category:'Soğuk İçecekler', name:'Yayık Ayran', price:35, img:'https://image.pollinations.ai/prompt/delicious%20Yay%C4%B1k%20Ayran%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=38', desc:'Bol köpüklü, taze naneli.'},
  {id:39, category:'Soğuk İçecekler', name:'Taze Portakal Suyu', price:70, img:'https://image.pollinations.ai/prompt/delicious%20Taze%20Portakal%20Suyu%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=39', desc:'%100 taze sıkılmış.'},
  {id:40, category:'Soğuk İçecekler', name:'Iced Latte', price:80, img:'https://image.pollinations.ai/prompt/delicious%20Iced%20Latte%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=40', desc:'Soğuk sütlü ve buzlu espresso.'},
  {id:41, category:'Soğuk İçecekler', name:'Sade Maden Suyu', price:30, img:'https://image.pollinations.ai/prompt/delicious%20Sade%20Maden%20Suyu%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=41', desc:'Limon dilimi ile.'},
  {id:42, category:'Soğuk İçecekler', name:'Soğuk Çay', price:45, img:'https://image.pollinations.ai/prompt/delicious%20So%C4%9Fuk%20%C3%87ay%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=42', desc:'Buzlu tatlı soğuk çay.'},

  // TATLILAR (7)
  {id:43, category:'Tatlılar', name:'Cheesecake', price:150, img:'https://image.pollinations.ai/prompt/delicious%20Cheesecake%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=43', desc:'Taze meyve soslu, fırınlanmış.'},
  {id:44, category:'Tatlılar', name:'İtalyan Tiramisu', price:140, img:'https://image.pollinations.ai/prompt/delicious%20%C4%B0talyan%20Tiramisu%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=44', desc:'Espresso ve taze mascarpone kreması.'},
  {id:45, category:'Tatlılar', name:'Fırın Sütlaç', price:90, img:'https://image.pollinations.ai/prompt/delicious%20F%C4%B1r%C4%B1n%20S%C3%BCtla%C3%A7%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=45', desc:'Üzeri kızarmış, fındıklı sütlaç.'},
  {id:46, category:'Tatlılar', name:'Çikolatalı Sufle', price:130, img:'https://image.pollinations.ai/prompt/delicious%20%C3%87ikolatal%C4%B1%20Sufle%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=46', desc:'İçi akışkan, vanilyalı dondurma ile.'},
  {id:47, category:'Tatlılar', name:'Künefe', price:160, img:'https://image.pollinations.ai/prompt/delicious%20K%C3%BCnefe%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=47', desc:'Özel peynirli, sıcak servis.'},
  {id:48, category:'Tatlılar', name:'Dondurma Tabağı', price:100, img:'https://image.pollinations.ai/prompt/delicious%20Dondurma%20Taba%C4%9F%C4%B1%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=48', desc:'Çikolata, vanilya ve çilekli 3 top.'},
  {id:49, category:'Tatlılar', name:'Profiterol', price:120, img:'https://image.pollinations.ai/prompt/delicious%20Profiterol%20dark%20moody%20lighting%2C%20food%20photography%2C%20high%20end%20luxury%20restaurant%2C%20highly%20detailed%2C%20photorealistic?width=600&height=400&nologo=true&seed=49', desc:'Bol çikolata soslu şu hamuru.'}
];

function getGlobalState() {
  const s = localStorage.getItem(STORAGE_KEY);
  if (s) {
    let parsed = JSON.parse(s);
    if(!parsed.categories) parsed.categories = defaultCategories;
    if(!parsed.products) parsed.products = defaultProducts;
    if(!parsed.tables) parsed.tables = 25;
    if(!parsed.users) parsed.users = [{id:1, role:'admin', name:'Yönetici'}];
    return parsed;
  }
  return { 
    calls: {}, 
    orders: [], 
    tables: 25,
    categories: defaultCategories,
    products: defaultProducts,
    users: [{id:1, role:'admin', name:'Yönetici'}]
  };
}

function saveGlobalState(state) {
  localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
  BC.postMessage({ type: 'STATE_UPDATED' });
}
