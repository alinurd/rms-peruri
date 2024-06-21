 WHEN ((a.score >= a.s_1_min) AND (a.score < a.s_1_max)) THEN 1
          --  WHEN ((a.score >= a.s_4_min) AND (a.score < a.s_4_max)) THEN 2
            WHEN ((a.score >= a.s_2_min) AND (a.score < a.s_2_max)) THEN 3
         --   WHEN ((a.score >= a.s_5_min) AND (a.score < a.s_5_max)) THEN 4
            WHEN ((a.score >= a.s_3_min) AND (a.score <= a.s_3_max)) THEN 5
            ELSE 0
