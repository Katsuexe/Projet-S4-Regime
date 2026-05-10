rows = [
    (1, 'Méditerranéen', 'Inspiré des pays du bassin méditerranéen, riche en poisson, légumes et huile d\'olive. Idéal pour atteindre un IMC équilibré.', 20.00, 40.00, 40.00, -0.50, 0.20),
    (2, 'Hyperprotéiné', 'Régime riche en protéines animales favorisant la prise de masse musculaire et l\'augmentation du poids corporel.', 50.00, 20.00, 30.00, 0.30, 1.00),
    (3, 'Hypocalorique', 'Régime à faible apport calorique basé sur la volaille maigre et le poisson pour une perte de poids progressive.', 15.00, 35.00, 50.00, -1.50, -0.30),
    (4, 'Cétogène', 'Très faible en glucides, très riche en protéines et lipides. Favorise une perte de poids rapide par cétose.', 60.00, 10.00, 30.00, -2.00, -0.50),
    (5, 'Flexitarien marin', 'Priorité au poisson et à la volaille, viande réduite au minimum. Équilibré et durable pour maintenir l\'IMC idéal.', 5.00, 55.00, 40.00, -0.80, 0.10),
]

def h(s):
    return s.encode('utf-8').hex()

print('SET NAMES utf8mb4;')
print('INSERT INTO `regimes` (`id`, `nom`, `description`, `pct_viande`, `pct_poisson`, `pct_volaille`, `delta_poids_min`, `delta_poids_max`) VALUES')
for i, row in enumerate(rows, start=1):
    id_, nom, desc, v1, v2, v3, v4, v5 = row
    sep = ',' if i < len(rows) else ';'
    print(f"({id_}, CONVERT(x'{h(nom)}' USING utf8mb4), CONVERT(x'{h(desc)}' USING utf8mb4), {v1:.2f}, {v2:.2f}, {v3:.2f}, {v4:.2f}, {v5:.2f}){sep}")
